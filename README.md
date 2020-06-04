Экземенационное задание «Паттерны проектирования, MVC, ADR»
===========================================================

Задание состоит из нескольких частей. Каждая часть описана ниже под заголовком «Задача». Также даны примеры приблизительной реализации и их объяснения.

-----------------------------------------------------------

Задача
------

Существуют источники данных в виде `csv` и `json`-файлов. Нулевая (самая верхняя) строка `csv`-файла содержит имена полей, `json` — это массив одинаковых по структуре «плоских» объектов, каждый из них также содержит имена полей.

Необходимо реализовать пакет (комплект классов), который будет читать данные из этих источников и предоставлять их в виде программных сущностей (объектов и массивов). Использовать паттерны Repository, Adapter.

Пакет должен предоставлять возможность выборки одной строки (json-объекта) по полю ID и получения заданного количества объектов с заданным смещением (n строк начиная со строки m или n объектов начиная с m от начала). Смещение — необязательный параметр.

Результатом работы поиска по ID должен быть стандартный объект (`\StdClass`) с полями, названными по значениям нулевой строки в случае с `csv` или именам полей `json` и значениями полей с соответствующим ID.

Результатом выборки — `Iterable`-объект (массив) со стандартными объектами внутри.

Входящие условия:

- поля `date`, `birthday`, `issueDate` содержит строку с датой формата `d.m.Y` (или null);
- поле ID всегда содержит число и не может быть пустым;
- объем данных не будет превышать количество оперативной памяти (все данные источника можно прочитать за один раз);

Условия выполнения

- все пустые поля должны интерпретироваться как null;
- при поиске по ID в случае отсутствия запрошенного ID должен возвращаться null;
- при выборке диапазона:
  - если значение смещения больще количества объектов, должно быть брошено исключение;
  - если количество объектов меньше заданного, должно возвратиться максимально доступное количество объектов;


Примерный план выполнения
-------------------------

**Adapter**

Поскольку нам нужно читать данные из разных источников одинаковым способом, необходим интерфейс с методом `connect` (для установки соединения / открытия файла) и методом `getData`, возвращающим данные источника. 

Обе реализации этого интерфейса (для `csv` и `json`) будут открывать целевой файл, читать из него данные и возвращать массив объектов.

Примеры смотрите в каталоге `examples/Adapter`.

**Repository**

Поскольку мы имеем два (или больше) источника данных для системы, репозиторий должен понимать, с каким из источников он будет работать. Поэтому в конструктор репозитория должен передаваться экземпляр источника данных, являющися имплементацией интерфейса адаптера.

Поскольку адаптер всегда возвращает одинаковыую структуру, имеет смысл вынести методы

- `find($id)` для поиска заданного ID,
- `get($number, $offset = 0)` для выборки нужного количества объектов

в абстрактный класс, а в конкретном его выражении оставить только конструктор, в который и передавать соответствующий адаптер.

Смотрите примеры в `examples/Repository/AbstractRepository.php`

-----------------------------------------------------------

Задача
------

DataMapper для репозитория. 

Изменить созданный на предыдущем этапе репозиторий так, чтобы он возвращал не стандартный объект (или массив объектов), а экземпляр класса, имя которого передано в конструктор. Предусмотреть ситуацию обратной совместимости — если имя класса не передано, поведение должно остаться прежним, то есть должны возвращаться стандартные объекты. 

Объект должен формироваться с помощью фабрики (реализация — на ваше усмотрение).

Примерный план выполнения
-------------------------

Добавляем в конструктор репозитория параметр `?string $className` и приватный метод `populate`, получающий объект и имя класса. Если передано имя класса, вызываем фабрику для построения заданного объекта.

Класс фабрики в методе `build` (или `make`) из имени целевого класса создаёт ReflectionObject, получает все его свойства, определяет тип каждого (если это возможно), находит имя свойства в исходном объекте и присваивает значение исходного свойства полю целевого класса.

Пример фабрики в `examples/ObjectFactory/Factory.php`    
Пример репозитория для класса `Example\Entity\Vehicle` в `examples/Repository/VehicleRepository.php`

