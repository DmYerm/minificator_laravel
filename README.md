## Мініфікатор лінків

Основні характеристики:
 - Користувач на початковому вікні бачить можливість ввести лінку, яку хоче мініфікувати та час, до якого зменшена лінка буде працювати
 - Якщо користувач не введе час, до якого лінка буде доступна, то вона буде доступна вічно.
 - Якщо користувач введе минулий час, то він отримає нову ссилку, яка не буде працювати
 - При створенні мініфікованної лінки користувача одразу перекине на екран статистики
 - Якщо буде введена лінка, яка наразі працює, з іншим часом придатності, час перезапишеться

 - На початковому екрані користувач також може ввести мініфіковану лінку і подивитись статистику по ній.

 - При переході по мініфікованій лінці до кількості переходів додається 1 (немає залежності від сессії, ip-адреси, тощо).


## Запуск на локальній машині:
 - Стягніть проект з гітхабу
 - Встановіть php 8.1
 - Встановіть composer
 - Перейдіть в папку проекту і введіть команду "./vendor/bin/sail up"
 - Далі запустіть команду "composer install"
 - Запустіть команду "sail php artisan migrate"
 - Насолоджуйтесь
