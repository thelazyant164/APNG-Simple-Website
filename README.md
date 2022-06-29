# Simple Website on APNG

Created as coursework for Computing Inquiry Project - COS10026, Swinburne University of Technology, Semester 1, 2022.

### Prerequisites

Should load without issue on any modern browser supporting the sufficient technology involved in creating this simple website. See dependency for more details.

### Installing

Clone everything in [assign1/](https://github.com/thelazyant164/COS10026-APNG-Group-Assignment/tree/master/assign1) for the static version, without PHP backend logic or database integration.
OR, run straight from the GitHub page URL for the [index page](https://thelazyant164.github.io/COS10026-APNG-Group-Assignment/assign1/index.html).

Clone everything in [assign3/](https://github.com/thelazyant164/COS10026-APNG-Group-Assignment/tree/master/assign3) for the extended version, which requires additional configuration to get running.

## Deployment

The static version, found in [assign1/](https://github.com/thelazyant164/COS10026-APNG-Group-Assignment/tree/master/assign1), can be run out-of-the-box from localhost as only vanilla HTML5 and CSS3 are used. Any modern browser with proper support should suffice.

The extended version, found in [assign3/](https://github.com/thelazyant164/COS10026-APNG-Group-Assignment/tree/master/assign3), is a bit more tricky.
Website can be hosted on an Apache server with sufficient PHP support.
Database credentials are read from [env/settings.php](https://github.com/thelazyant164/COS10026-APNG-Group-Assignment/blob/master/assign3/env/settings.php) - change this to a working database for the website to run properly.

## Built With

* [JPGraph](https://jpgraph.net/) - The PHP library used for visualizing statistics
* [FeeNIX](https://feenix.swin.edu.au/help/) - Environment where the website is deployed, with dedicated Apache server Mercury for hosting & MariaDB for storing quiz attempts
* Apart from that, vanilla HTML5 & CSS3 for frontend, with PHP for backend logic & MySQL syntax for database query

## Authors

* **Aly** -  *Developer, Designer, Q&A, PM* - [thelazyant164](https://github.com/thelazyant164)
* **Jacky** -  *Leader, Developer, Researcher* - [Jckyy](https://github.com/Jckyy)
* **Jian** -  *Developer* - [Lornng](https://github.com/Lornng)
* **Ravish** -  *Developer* - [ravishrandev](https://github.com/ravishrandev)
* **Jack** -  *Developer* - [TalonRaptor](https://github.com/TalonRaptor)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* [Rafael Morais](https://codepen.io/rafaelsnts) for a clever implementation of a functional [dark mode without JavaScript](https://codepen.io/rafaelsnts/pen/BEzZoX)
* [Alvaro Trigo](https://alvarotrigo.com/)'s blog & tutorial for a beautiful [parallax scrolling effect without JavaScript](https://alvarotrigo.com/blog/how-to-create-a-parallax-effect-with-css-only/)
* Course curriculum for COS10026 unit, with introduction to some traditional technology used in web application
* [W3School](https://www.w3schools.com/) & [JavaTPoint](https://www.javatpoint.com/) tutorial, with concise instructions & helpful knowledge
