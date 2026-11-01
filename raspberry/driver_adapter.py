"""Hardware adapter placeholder. Implement only after confirming the actual motor/driver."""

class MachineDriver:
    def __init__(self):
        self.ready = False

    def start(self, settings):
        raise NotImplementedError("Implementasikan driver motor yang sesuai perangkat keras sebelum mengaktifkan mesin.")

    def configure(self, settings):
        raise NotImplementedError("Implementasikan konfigurasi driver setelah memverifikasi perangkat keras.")

    def stop(self):
        raise NotImplementedError("Implementasikan STOP perangkat keras dan uji emergency-stop secara fisik.")
