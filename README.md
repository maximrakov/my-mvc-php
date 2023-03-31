# Проект разработки собственного фреймворка (MVC) на основе приложения TODO.

## Разработка основы фреймворка.

1. Настройка composer с подключением autoload который он предоставляет.
2. Разработка роутинга проекта.
Необходимо сделать роутинг который позволит принимать GET и POST. При этом в GET роутинге позволяется делать подстановку параметров например:
/task/{id} - где id параметр который будет передан в контроллер.

Так же роутинг должен уметь поддерживать регулярные выражения. Например:
/task/.* - все роуты начинающиеся на task и дальше не важно что. При этом если мы обьорачиваем в {} выражение .*, то данная строка должна попасть в качестве параметра в контроллер.

Роутинг должен принимать 2 параметра. Первым идет сама строчка роута, а вторым строка (путь) к котороллеру который будет обрабатывать логику контроллера.