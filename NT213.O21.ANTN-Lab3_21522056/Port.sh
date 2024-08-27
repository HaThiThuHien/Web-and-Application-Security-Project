#!/bin/bash

of="Port.txt"

while IFS= read -r host; do
    ip=$(nslookup "$host" | awk '/^Address: / {print $2}' | head -n 1)
    
    if [ -n "$ip" ]; then
        echo "$host $ip" >> "$of"
        docker run projectdiscovery/naabu -top-ports 1000 -host $host > tmp.txt
        cat tmp.txt | grep $host | cut -d ':' -f2 >> $of
        echo "----------------------------------------------"  >> $of
    else
        echo "$host NOT_FOUND" >> "$of"
        echo "----------------------------------------------"  >> $of
    fi
done < domain.txt