class Server:
    counter = 1

    def __init__(self):
        self.ip = Server.counter
        Server.counter += 1
        self.buffer = []
        self.router = None

    def send_data(self, data):
        self.router.buffer.append(data)

    def get_data(self):
        return self.buffer[:] if self.buffer else []

    def get_ip(self):
        return self.ip


class Router:
    def __init__(self):
        self.buffer = []
        self.servers = {}

    def link(self, server):
        self.servers[server.ip] = server
        server.router = self

    def unlink(self, server):
        self.servers.pop(server.ip)
        server.router = None

    def send_data(self):
        for smth in self.buffer:
            self.servers[smth.ip].buffer.append(smth.data)


class Data:
    def __init__(self, data, ip):
        self.data = data
        self.ip = ip


router = Router()
sv_from = Server()
sv_to = Server()

router.link(sv_from)
router.link(sv_to)


sv_from.send_data(Data("Hello", sv_to.get_ip()))
sv_to.send_data(Data("Hi", sv_from.get_ip()))

router.send_data()

msg_lst_from = sv_from.get_data()
msg_lst_to = sv_to.get_data()
