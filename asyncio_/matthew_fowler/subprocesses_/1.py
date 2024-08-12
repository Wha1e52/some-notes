"""
Библиотека asyncio предлагает две сопрограммы для создания подпроцессов:
asyncio.create_subprocess_shell и asyncio.create_subprocess_exec.
Обе они возвращают экземпляр класса Process, имеющего, наряду с прочими, методы
для завершения и ожидания завершения процесса. Зачем нужны две
сопрограммы для решения вроде бы одной и той же задачи? Когда
использовать одну, а когда другую? Сопрограмма create_subprocess_
shell создает подпроцесс внутри установленной в системе оболочки,
например zsh или bash. Вообще говоря, лучше использовать create_
subprocess_exec, если только не нужна функциональность оболочки.
С использованием оболочки связаны различные подводные камни,
например на разных машинах могут быть установлены разные обо-
лочки или одна и та же, но по-разному сконфигурированная. Из-за
этого трудно гарантировать, что приложение будет вести себя одина-
ково на разных машинах.

"""
import asyncio
from asyncio import StreamReader
from asyncio.subprocess import Process


async def write_output(prefix: str, stdout: StreamReader):
    while line := await stdout.readline():
        print(f'[{prefix}]: {line.rstrip().decode("cp866")}')


async def main():
    program = ['cmd', '/c', 'dir']
    process: Process = await asyncio.create_subprocess_exec(*program, stdout=asyncio.subprocess.PIPE)
    print(f'pid процесса: {process.pid}')
    stdout_task = asyncio.create_task(write_output(' '.join(program), process.stdout))
    return_code, _ = await asyncio.gather(process.wait(), stdout_task)
    print(f'Процесс вернул: {return_code}')
asyncio.run(main())