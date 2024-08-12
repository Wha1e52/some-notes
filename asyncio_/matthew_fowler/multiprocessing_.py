# todo 6
"""
Вместо запуска потоков для распараллеливания работы родительский процесс будет запускать дочерние процессы.
В каждом дочернем процессе работает отдельный интерпретатор Python со своей GIL.
И даже если процессов больше, чем ядер,
механизм вытесняющей многозадачности, встроенный в операцион-
ную систему, позволит выполнять задачи конкурентно. Такая конфи-
гурация является конкурентной и параллельной.

Многопроцессные приложения могут конкурентно выполнять несколько команд байт-кода, потому что
у каждого Python-процесса своя собственная GIL.


Обратите внимание на предложение if __name__ == "__main__":,
с которым мы раньше не встречались. Это особенность библиотеки
multiprocessing; если этого не сделать, то возможно появление ошиб-
ки «An attempt has been made to start a new process before the current
process has finished its bootstrapping phase» (Попытка запустить новый
процесс до завершения фазы инициализации текущего процесса).
Нужно это для того, чтобы помешать другим программам, импорти-
рующим ваш код, случайно запустить несколько процессов.

Метод join не возвращает то значение, которое вернула выполненная функция;
на самом деле вообще не существует способа получить возвращенное ей значение
без использования разделяемой памяти!

Один из механизмов для синхронизации доступа к разделяемым
данным называется блокировкой, или мьютексом (от mutual exclusion –
взаимное исключение). Он позволяет одному процессу заблокировать
участок кода, т. е. запретить всем остальным его выполнение. Заблоки-
рованный участок обычно называют критической секцией. Если один
процесс выполняет код в критической секции, а второй пытаемся вы-
полнить тот же код, то второму придется подождать (арбитр не пуска-
ет его), пока первый закончит работу и выйдет из критической секции.

Чтобы захватить блокировку, нужно вызвать get_lock(). acquire(), а для ее освобождения – метод get_lock().release().
Заметим, что блокировки являются контекстными менеджерами, и, чтобы сделать код чище, мы могли бы
использовать в функции increment_value блок with. Тогда захват
и освобождение блокировки будут производиться автоматически:

def increment_value(shared_int: Value):
    with shared_int.get_lock():
        shared_int.value = shared_int.value + 1

Чтобы избежать гонки, код в критических секциях обязан выполняться по-
следовательно. Это может отрицательно сказаться на производитель-
ности многопроцессного кода. Поэтому нужно внимательно следить
за тем, чтобы защищать блокировкой только то, что абсолютно не-
обходимо, и не мешать остальному коду выполняться конкурентно.
Столкнувшись с состоянием гонки, не нужно идти по легкому пути
и защищать блокировкой все вообще. Проблему-то вы решите, но,
скорее всего, производительность сильно пострадает.


"""
import concurrent
import time
from concurrent.futures import ProcessPoolExecutor
import functools
import asyncio
from multiprocessing import Value
from typing import List, Dict


map_progress: Value


def init(progress: Value):
    global map_progress
    map_progress = progress


def partition(data: List, chunk_size: int) -> List:
    for i in range(0, len(data), chunk_size):
        yield data[i:i + chunk_size]


def map_frequencies(chunk: List[str]) -> Dict[str, int]:
    counter = {}
    for line in chunk:
        word, _, count, _ = line.split('\t')
        if counter.get(word):
            counter[word] = counter[word] + int(count)
        else:
            counter[word] = int(count)

    with map_progress.get_lock():
        map_progress.value += 1

    return counter


async def progress_reporter(total_partitions: int):
    while map_progress.value < total_partitions:
        a = map_progress.value / total_partitions
        print(f'\rЗавершено операций отображения: {map_progress.value / total_partitions * 100:.0f}/{100} %', end="")
        await asyncio.sleep(0.01)


def merge_dictionaries(first: Dict[str, int], second: Dict[str, int]) -> Dict[str, int]:
    merged = first
    for key in second:
        if key in merged:
            merged[key] = merged[key] + second[key]
        else:
            merged[key] = second[key]
    return merged


async def reduce(loop, pool, counters, chunk_size) -> Dict[str, int]:
    chunks: List[List[Dict]] = list(partition(counters, chunk_size))
    reducers = []
    while len(chunks[0]) > 1:
        for chunk in chunks:
            reducer = functools.partial(functools.reduce, merge_dictionaries, chunk)
            reducers.append(loop.run_in_executor(pool, reducer))
        reducer_chunks = await asyncio.gather(*reducers)
        chunks = list(partition(reducer_chunks, chunk_size))
        reducers.clear()
    return chunks[0][0]


async def main(partition_size: int):
    global map_progress

    with open(r'C:\Users\user\Downloads\googlebooks-eng-all-1gram-20120701-a\googlebooks-eng-all-1gram-20120701-a', encoding='utf-8') as f:
        contents = f.readlines()
        loop = asyncio.get_running_loop()
        tasks = []
        map_progress = Value('i', 0)
        print("файл открыт. Отображение началось.")
        with concurrent.futures.ProcessPoolExecutor(initializer=init, initargs=(map_progress,)) as pool:
            total_partitions = len(contents) // partition_size
            reporter = asyncio.create_task(progress_reporter(total_partitions))
            for chunk in partition(contents, partition_size):
                tasks.append(loop.run_in_executor(pool, functools.partial(map_frequencies, chunk)))
            counters = await asyncio.gather(*tasks)
            final_result = functools.reduce(merge_dictionaries, counters)
            print()
            print(f"Aardvark встречается {final_result['Aardvark']} раз.")

if __name__ == "__main__":
    asyncio.run(main(partition_size=70000))

