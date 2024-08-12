"""
When you enter a domain name into your web browser, your computer sends a DNS query to a DNS server, which returns
the corresponding IP address. Your computer then uses that IP address to connect to the website or other resource
you’ve requested.
When you visit a website, your web browser sends an HTTP request to the server, asking for
the webpage or other resource you’ve requested. The server then sends an HTTP response back to the client,
containing the requested data.

Several things happen when a user types https://www.google.com into their web browser and
hits Enter. First the browser needs to find the desired server, somewhere, on the vast internet.
It uses a domain name service (DNS) to translate the domain name “google.com” into an IP
address17, which is a unique sequence of numbers representing every connected device on the
internet. Domain names are used because it is easier for humans to remember a domain name
like “google.com” than an IP address like “172.217.164.68”.
After the browser has the IP address for a given domain, it needs a way to set up a consistent
connection with the desired server. This happens via the Transmission Control Protocol (TCP)
which provides reliable, ordered, and error-checked delivery of bytes between two application.
To establish a TCP connection between two computers, a three-way “handshake” occurs
between the client and server:
1. The client sends a SYN asking to establish a connection
2. The server responds with a SYN-ACK acknowledging the request and passing a connection
parameter
3. The client sends an ACK back to the server confirming the connection
Once the TCP connection is established, the two computers can start communicating via HTTP.

todo What is the internet?
A network is a group of computers or other devices which are connected to each other.
All these networks when connected together form the internet.
The internet is a network of networks.
The internet is a global network of interconnected computers that uses a standard set of communication protocols
to exchange data.

At a high level, the internet works by connecting devices and computer systems together using a set of standardized
protocols. These protocols define how information is exchanged between devices and ensure that data is transmitted
reliably and securely.
A protocol is a set of rules and standards that define how information is exchanged between devices and systems.

The core of the internet is a global network of interconnected routers, which are responsible for directing traffic
between different devices and systems. When you send data over the internet, it is broken up into small packets that
are sent from your device to a router. The router examines the packet and forwards it to the next router in the path
towards its destination. This process continues until the packet reaches its final destination.

To ensure that packets are sent and received correctly, the internet uses a variety of protocols, including the
Internet Protocol (IP) and the Transmission Control Protocol (TCP). IP is responsible for routing packets to their
correct destination, while TCP ensures that packets are transmitted reliably and in the correct order.

todo What’s an IP address?
IP Address: A unique identifier assigned to each device on a network, used to route data to the correct destination.

todo What is IPv6?
The current internet standard, known as IPv4, only allows for about 4 billion IP addresses. This
was considered a very big number in the 1970s, but today, the supply of IPv4 addresses is nearly exhausted.
So internet engineers have developed a new standard called IPv6. IPv6 allows for a mind-boggling number of unique
addresses — the exact figure is 39 digits long — ensuring that the world will never again run out.

todo What is a packet?
Packet: A small unit of data that is transmitted over the internet.
A packet has two parts.
The header contains information that helps the packet get to its destination, including the length of the packet,
its source and destination, and a checksum value that helps the recipient detect if a packet was damaged in transit.
After the header comes the actual data. A packet can contain up to 64 kilobytes of data, which is roughly 20 pages of
plain text.

Router: A device that directs packets of data between different networks.
Domain Name: A human-readable name that is used to identify a website, such as google.com.

todo What is the Domain Name System?
DNS: The Domain Name System is responsible for translating domain names into IP addresses.

todo What is HTTP?
HTTP: The Hypertext Transfer Protocol is used to transfer data between a client (such as a web
browser) and a server (such as a website).

HTTP is a request-response protocol between two computers that have an existing TCP connection.
The computer making the requests is known as the client while the computer responding
is known as the server. Typically a client is a web browser but it could also be an iOS app or really
any internet-connected device.

HTTPS: An encrypted version of HTTP that is used to provide secure communication between a client and server.

todo What is TCP/IP
TCP/IP (Transmission Control Protocol/Internet Protocol) is the underlying communication protocol used by most
internet-based applications and services. It provides a reliable, ordered, and error-checked delivery of data between
applications running on different devices.

Протокол TCP (transmission control protocol – протокол управления пе-
редачей) предназначен для передачи данных между приложениями по
сети. При его проектировании на первое место ставилась надежность. Он
проверяет ошибки, гарантирует доставку данных по порядку и в случае
необходимости производит повторную передачу. Но надежность сопро-
вождается высокими накладными расходами. Большая часть веба функ-
ционирует на базе TCP. Противоположностью TCP является протокол
передачи дейтаграмм UDP, менее надежный, но и характеризующийся
гораздо меньшими накладными расходами, чем TCP, а потому более про-
изводительный.




Ports: Ports are used to identify the application or service running on a device. Each application or service is
assigned a unique port number, allowing data to be sent to the correct destination.

Sockets: A socket is a combination of an IP address and a port number, representing a specific endpoint for
communication. Sockets are used to establish connections between devices and transfer data between applications.

Connections: A connection is established between two sockets when two devices want to communicate with each other.
During the connection establishment process, the devices negotiate various parameters such as the maximum segment
size and window size, which determine how data will be transmitted over the connection.

Data transfer: Once a connection is established, data can be transferred between the applications running on each
device. Data is typically transmitted in segments, with each segment containing a sequence number and other metadata
to ensure reliable delivery.

todo What is SSL?
SSL/TLS: The Secure Sockets Layer and Transport Layer Security protocols are used to provide secure communication
over the internet.

SSL, short for Secure Sockets Layer, is a family of encryption technologies that allows web users to protect the
privacy of information they transmit over the internet.

todo What is REST?
Representational State Transfer (REST) is an architecture first proposed in 2000 by Roy Fielding in his
dissertation thesis. It is an approach to building APIs on top of the web, which means on top of the HTTP protocol.

Every RESTful API:
• is stateless, like HTTP
• supports common HTTP verbs (GET, POST, PUT, DELETE, etc.)
• returns data in either the JSON or XML format

Any RESTful API must, at a minimum, have these three principles. The standard is important
because it provides a consistent way to both design and consume web APIs.














"""






















