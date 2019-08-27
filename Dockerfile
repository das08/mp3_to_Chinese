FROM php:7.4-rc-apache

# Copy the application
COPY Chinese.html WatsonSpeechToText.php css js robots.txt up2.php ./

# Insert Watson API Key
COPY apikey after.sh ./

RUN ["/bin/sh", "./after.sh"]
