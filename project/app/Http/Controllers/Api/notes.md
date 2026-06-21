Di api ini itu send data 

Data Pipelines
User request Artiicles -> Request -> Route -> Data Fetch dari API -> API kirim -> User terima

UI Pipelines
User request -> Ajax send request -> Ajax terima request -> Dan terima page routing ke mana -> Route di handle AJAX.

Routing data dan page dibedakan
DI Data di handle full laravel

Di View di handle Ajax + Laravel
Laravel kirim address, ajax kirim request

Setelah API berhasil diterima VIEW, AJAX akan merequest viewnya akan kemana? 
-> Apakah Modal?
-> Apakah ganti page?
-> Apakah langsung di kick?


View -> Request Data -> API -> Response (+redirect url) -> View 