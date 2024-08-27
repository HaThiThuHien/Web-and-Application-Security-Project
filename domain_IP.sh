#!/bin/bash

of="IP.txt"

while IFS= read -r host; do
    ip=$(nslookup "$host" | awk '/^Address: / {print $2}' | head -n 1)

    if [ -n "$ip" ]; then
        echo "$host $ip" >> "$of" 
    else 
        echo "$host NOT_FOUND" >> "$of" 
    fi
done < domain.txt
