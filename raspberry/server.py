import hmac
import os
from flask import Flask, jsonify, request
from driver_adapter import MachineDriver

app = Flask(__name__)
TOKEN = os.environ.get("PINGPONG_API_TOKEN", "")
driver = MachineDriver()

VALID_MODES = {"target_shooting", "multi_ball", "game_mode", "custom"}
VALID_SPEEDS = {"low", "medium", "high"}
VALID_DIRECTIONS = {"left", "center", "right", "random"}

@app.before_request
def require_token():
    if request.path == "/health":
        return None
    supplied = request.headers.get("Authorization", "")
    expected = "Bearer " + TOKEN if TOKEN else ""
    if not TOKEN or not hmac.compare_digest(supplied, expected):
        return jsonify({"message": "Unauthorized"}), 401

@app.get("/health")
def health():
    # This is service health only; it does not imply motors are ready.
    return jsonify({"service": "up", "hardware_ready": False}), 200

@app.post("/api/control")
def control():
    data = request.get_json(silent=True) or {}
    action = data.get("action")
    if action not in {"start", "stop", "configure"}:
        return jsonify({"message": "Invalid action"}), 400

    # Always route STOP to the adapter; the adapter must be implemented and tested.
    try:
        if action == "stop":
            driver.stop()
            return jsonify({"accepted": True, "action": "stop"}), 200

        settings = {
            "mode": data.get("mode"),
            "speed": data.get("speed"),
            "interval_seconds": data.get("interval_seconds"),
            "direction": data.get("direction"),
        }
        if settings["mode"] not in VALID_MODES or settings["speed"] not in VALID_SPEEDS or settings["direction"] not in VALID_DIRECTIONS:
            return jsonify({"message": "Invalid settings"}), 400
        interval = settings["interval_seconds"]
        if isinstance(interval, bool) or not isinstance(interval, int) or interval < 1 or interval > 30:
            return jsonify({"message": "Interval must be 1..30 seconds"}), 400

        if action == "start":
            driver.start(settings)
        else:
            driver.configure(settings)
        return jsonify({"accepted": True, "action": action}), 200
    except NotImplementedError:
        return jsonify({"message": "Hardware adapter belum dikonfigurasi; perintah tidak dijalankan."}), 503
    except Exception:
        # Do not leak driver internals over the network.
        app.logger.exception("Hardware driver command failed")
        return jsonify({"message": "Hardware command failed; verify machine state locally."}), 500

if __name__ == "__main__":
    if not TOKEN:
        raise SystemExit("Set PINGPONG_API_TOKEN before starting the service.")
    # Bind only on the LAN interface in deployment; firewall this port to Laravel host.
    app.run(host="0.0.0.0", port=5000, debug=False)
