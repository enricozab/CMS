import sys
import os
from hellosign_sdk import HSClient

args = str(sys.argv)

title = str(sys.argv[1])
subject = str(sys.argv[2])
message = str(sys.argv[3])
email = str(sys.argv[4])
name = str(sys.argv[5])
filename = str(sys.argv[6])

"""
file = open("C://xampp//htdocs//CMS//ajax//samplefile.txt", "a")
file.write(str(sys.argv))
file.write(title)
file.write(subject)
file.write(message)
file.write(email)
file.write(name)
file.write(filename)
"""

client = HSClient(api_key='6c8ae769dc48d8feb6f78d369cb52815ab576c6b6c655385e2442e14a13f3bef')
client.send_signature_request(
	test_mode=True,
	title=title,
	subject=subject,
	message=message,
	signers=[{ 'email_address': email, 'name': name}] ,
	files=[filename]
)

os.remove(filename)