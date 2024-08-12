"""
By default, there are 5 standard levels indicating the severity of events.
Each has a corresponding function that  can be used to log events at that level of severity.
The defined levels, in order of increasing severity, are the following:

DEBUG
INFO
WARNING
ERROR
CRITICAL

import logging

logging.debug('This is a debug message')
logging.info('This is an info message')
logging.warning('This is a warning message')
logging.error('This is an error message')
logging.critical('This is a critical message')

The output of the above program would look like this:

WARNING:root:This is a warning message
...

todo basicConfig
https://docs.python.org/3/library/logging.html#logging.basicConfig

You can use the basicConfig(**kwargs) function to configure the logging
Some of the commonly used parameters for basicConfig() are the following:

level: The root logger will be set to the specified severity level.
filename: This specifies the file.
filemode: If filename is given, the file is opened in this mode. The default is a, which means append.
format: This is the format of the log message.

import logging

logging.basicConfig(level=logging.DEBUG)
logging.debug('This will get logged')

All events at or above DEBUG level will now get logged.

Similarly, for logging to a file rather than the console, filename and filemode can be used,
and you can decide the format of the message using format. The following example shows the usage of all three:

import logging

logging.basicConfig(filename='app.log', filemode='w', format='%(name)s - %(levelname)s - %(message)s')
logging.warning('This will get logged to a file')

It should be noted that calling basicConfig() to configure the root logger works only if
the root logger has not been configured before. Basically, this function can only be called once.
debug(), info(), warning(), error(), and critical() also call basicConfig() without arguments automatically if
it has not been called before. This means that after the first time one of the above functions is called,
you can no longer configure the root logger because they would have called the basicConfig() function internally.

todo Formatting the Output
https://docs.python.org/3/library/logging.html#logrecord-attributes

import logging

logging.basicConfig(format='%(asctime)s - %(message)s', datefmt='%d-%b-%y %H:%M:%S')
logging.warning('Admin logged out')

todo Capturing Stack Traces
import logging
a = 5
b = 0

try:
    c = a / b
except Exception as e:
    logging.error("Exception occurred", exc_info=True)

todo Classes and Functions
The most commonly used classes defined in the logging module are the following:

Logger: This is the class whose objects will be used in the application code directly to call the functions.

LogRecord: Loggers automatically create LogRecord objects that have all the information related to
the event being logged, like the name of the logger, the function, the line number, the message, and more.

Handler: Handlers send the LogRecord to the required output destination, like the console or a file.
Handler is a base for subclasses like StreamHandler, FileHandler, SMTPHandler, HTTPHandler, and more.
These subclasses send the logging outputs to corresponding destinations, like sys.stdout or a disk file.

Formatter: This is where you specify the format of the output by specifying a string format that
lists out the attributes that the output should contain.

Multiple calls to getLogger() with the same name will return a reference to the same Logger object, which
saves us from passing the logger objects to every part where it’s needed.

a custom logger can’t be configured using basicConfig(). You have to configure it using Handlers and Formatters

import logging

logger = logging.getLogger('example_logger')
logger.warning('This is a warning')

"""
import logging

# Create a custom logger
logger = logging.getLogger(__name__)

# Create handlers
c_handler = logging.StreamHandler()
f_handler = logging.FileHandler('file.log')
c_handler.setLevel(logging.WARNING)
f_handler.setLevel(logging.ERROR)

# Create formatters and add it to handlers
c_format = logging.Formatter('%(name)s - %(levelname)s - %(message)s')
f_format = logging.Formatter('%(asctime)s - %(name)s - %(levelname)s - %(message)s', datefmt='%m/%d/%Y %H:%M:%S')
c_handler.setFormatter(c_format)
f_handler.setFormatter(f_format)

# Add handlers to the logger
logger.addHandler(c_handler)
logger.addHandler(f_handler)

logger.warning('This is a warning')
logger.error('This is an error')

# ------------------------------------------ load config file

# import logging
# import logging.config
#
# logging.config.fileConfig(fname='config.ini', disable_existing_loggers=False)
#
# # Get the logger specified in the file
# logger = logging.getLogger(__name__)
#
# logger.error('This is a debug message')

# ------------------------------------------ load config from a yaml file

# import logging.config
# import yaml
#
# with open('config.yaml', 'r') as f:
#     config = yaml.safe_load(f.read())
#     logging.config.dictConfig(config)
#
# logger = logging.getLogger(__name__)
#
# logger.debug('This is a debug message')
