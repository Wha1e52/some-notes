import time

import pika, sys, os

def main():
    connection = pika.BlockingConnection(
        pika.ConnectionParameters(
            host='localhost',
            credentials=pika.PlainCredentials('rmuser', 'rmpassword')
        )
    )

    channel = connection.channel()

    def callback(ch, method, properties, body):
        print(f" [x] Received {body.decode()}")
        time.sleep(body.count(b'.'))
        print(" [x] Done")

    channel.basic_consume(queue='hello',
                          auto_ack=True,
                          on_message_callback=callback)
    print(' [*] Waiting for messages. To exit press CTRL+C')
    channel.start_consuming()


if __name__ == '__main__':
    main()
