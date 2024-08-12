import sys
import time

import pika

connection = pika.BlockingConnection(
    pika.ConnectionParameters(
        host='localhost',
        credentials=pika.PlainCredentials('rmuser', 'rmpassword')
    )
)

channel = connection.channel()
channel.queue_declare(queue='hello')

message = ' '.join(sys.argv[1:]) or "Hello World!"

channel.basic_publish(exchange='',
                      routing_key='hello',
                      body=message)
print(f" [x] Sent {message}")
connection.close()
