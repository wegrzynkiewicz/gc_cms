start cmd.exe /k "cd .. && php -S localhost:8080"
start "" "%ProgramFiles%\Git\git-bash.exe" -c "cd .. && git lg && git status && /usr/bin/bash --login -i"
start explorer ..
start cmd.exe /k "atom .. && exit"
start chrome "http://localhost:8080/web/index.php/admin"
start chrome "http://localhost:8080/web/index.php/root/adminer"
