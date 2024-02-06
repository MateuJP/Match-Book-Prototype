# Match Book

## Descripción del Proyecto

En el verano de 2021, desarrollé un **prototipo** con el objetivo de crear una plataforma para compartir libros entre usuarios dentro de una misma ciudad. Esta plataforma fue concebida como un espacio donde los amantes de la lectura podrían intercambiar libros que ya han leído por aquellos que desean leer, fomentando así una comunidad de lectura colaborativa.

El sistema de la plataforma requiere que los usuarios definan dos listas principales al registrarse:

- **Lista de Deseos**: En esta lista, los usuarios pueden agregar los libros que desean leer en el futuro. Estos podrían ser libros que han sido recomendados, obras de autores favoritos o simplemente títulos que han despertado su interés.
- **Lista de Compartir**: Aquí, los usuarios pueden enumerar los libros que ya han leído y que están dispuestos a compartir con otros usuarios. Esta lista actúa como un repositorio de libros disponibles para intercambiar.

El sistema ofrece dos métodos de búsqueda:

- **Match**: Supongamos que Bob es un usuario que busca un match, para ello seleccionará una ciudad de España en la que quiera encontrar el match. El sistema buscará aquellos usuarios que tengan en su lista para compartir un libro que Bob tiene en su lista de deseos y a su vez, Bob tenga en su lista para compartir un libro que ellos tienen en su lista de deseos. Una vez encontrados, el sistema muestra los resultados a Bob para que pueda elegir el usuario con quien intercambiar el libro, de forma que ambos salen ganando, ya que obtienen un libro que desean.

- **Búsqueda por Título**: En este modo de búsqueda, simplemente se tiene que introducir el título de la obra, el autor y la ciudad donde se desea realizar la búsqueda. El sistema se encarga de buscar todos aquellos usuarios que en su lista para compartir tengan dicho título y pone en contacto a ambas partes para llevar a cabo el intercambio que deseen.

El propósito fundamental de este sistema no radica en la compra o venta de libros, sino que nace de la premisa de que en nuestros hogares a menudo tenemos libros que ya hemos leído y que, aunque ya no nos interesan, podrían ser de gran utilidad para otra persona. A su vez, esa persona podría tener libros que no nos interesan, pero que podrían captar nuestra atención.

El sistema se concibió como una solución para facilitar el intercambio de estos libros entre individuos. Reconociendo que lo que uno ya ha leído puede ser valioso para otros, y viceversa, se buscó crear una plataforma donde los usuarios pudieran ofrecer los libros que ya no desean conservar y, a su vez, buscar aquellos que desean adquirir.

Este enfoque se basa en la idea de compartir y reutilizar recursos, en este caso, libros, que de otra manera podrían quedar relegados o incluso descartados. Así, se promueve una comunidad donde se fomenta la lectura, se facilita el acceso a una variedad de títulos y se fortalecen los lazos sociales a través del intercambio cultural y la colaboración mutua.

El objetivo no es simplemente deshacerse de libros que ya no nos interesan, sino crear una red de intercambio en la que todos los participantes puedan beneficiarse, encontrando nuevos tesoros literarios mientras comparten los suyos propios. En última instancia, este sistema busca no solo enriquecer las bibliotecas personales de los usuarios, sino también promover un sentido de comunidad basado en la generosidad y la solidaridad entre lectores.

## Herramientas utilizadas

Este proyecto sigue el patrón de diseño Modelo-Vista-Controlador (MVC), el cual divide la aplicación en tres partes principales: el Modelo (manejo de datos y lógica empresarial), la Vista (presentación de la interfaz de usuario) y el Controlador (intermediario entre el modelo y la vista).
El modelo y el controlador han sido desarrollados en PHP y la vista en HTML, CSS y JS.

## Siguientes pasos

El foco de este proyecto ha estado centrado en el backend, más que en el frontend. De hecho, para este prototipo se ha desarrollado una interfaz muy simple que permite comprobar que todas las funcionalidades backend funcionan como se esperaba.

Los siguientes pasos están centrados, en retomar el proyecto y mejorar la interfaz de usuario, haciendo un diseño responsive, moderno y atractivo que pueda atraer al mayor número de usuarios posibles.

Asimismo, una vez implementada la interfaz de usuario, el siguiente paso será crear un sistema de comunicaciones en la propia aplicación, ya que actualmente los usuarios que hacen match se les da la oportunidad de ponerse en contacto a través de redes sociales. Con un chat interno se podría tener un mayor control y proteger a nuestros usuarios.
