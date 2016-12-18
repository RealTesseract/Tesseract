#!/bin/bash
curl -fsSL https://github.com/TesseractTeam/DevTools/releases/download/1/DevTools.phar -o plugins/DevTools.phar
echo Running lint...
shopt -s globstar
for file in **/*.php; do
    OUTPUT=`php -l "$file"`
    [ $? -ne 0 ] && echo -n "$OUTPUT" && exit 1
done
echo Lint done successfully.
echo -e "version\nms\nstop\n" | php src/pocketmine/PocketMine.php --no-wizard | grep -v "\[Tesseract] Adding "
if ls plugins/Tesseract/Tesseract*.phar >/dev/null 2>&1; then
    echo Server packaged successfully.
else
    echo No phar created!
    exit 1
fi
