class CustomFuture:
    def __init__(self):
        self._result = None
        self._is_finished = False
        self._done_callback = None

    def result(self):
        return self._result

    def is_finished(self):
        return self._is_finished

    def set_result(self, result):
        self._result = result
        self._is_finished = True
        if self._done_callback:
            self._done_callback(result)

    def add_done_callback(self, fn):
        self._done_callback = fn

    def __await__(self):
        if not self._is_finished:
            yield self
        return self.result()


future = CustomFuture()
i = 0
while True:
    try:
        print('Проверяется будущий объект...')
        gen = future.__await__()
        gen.send(None)
        print('Будущий объект не готов...')
        if i == 2:
            print('Устанавливается значение будущего объекта...')
            future.set_result('Готово!')
        i = i + 1
    except StopIteration as si:
        print(f'Значение равно: {si.value}')
        break