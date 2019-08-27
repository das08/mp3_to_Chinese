#!/bin/sh

key=`cat apikey` &&
sed -i "s/{apikey is placed here}/$key/" WatsonSpeechToText.php&& 
rm apikey
