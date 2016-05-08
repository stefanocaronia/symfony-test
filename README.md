# Pronto Test

Questo è un progetto di test per prontopro.it, che consiste in un sistema minimale per la gestione di prodotti, con classificazione basata su tag.

## Principali funzionalità

* creazione prodotto
* upload foto prodotto
* visualizzazione lista prodotti ordinati per data di creazione
* filtro per tag su lista prodotti
* modifica prodotto esistente
* eliminazione prodotto

## Tecnologie utilizzate

Per realizzare il progetto ho utilizzato:

* php 5.6
* framework Symfony v.3.0.5
* composer 1.2
* Doctrine 2.5
* SqLite
* bootstrap 3.3
* git 2.7.2
	
## Installazione

Effettuare il checkout e poi eseguire

```
composer update
```

per aggiornare i pacchetti
	
## Struttura file

- app/Resources/views
	* base.html.twig : template base pagina
	* list.html.twig : lista prodotti
	* create.html.twig : pagina di creazione prodotto
	* edit.html.twig : pagina di modifica prodotto
- app/db
	* sqlite.db : database SqLite
- src/AppBundle/Controller
	* ProductController.php : controller e definizione route (annotazioni)
- src/AppBundle/Entity
	* Product.php : classe per entity prodotto
- src/AppBundle/Form
	* ProductType.php : schema per costruzione form prodotto	
- web/common/css
	* style.css : foglio di stile principale
- web/common/js
	* main.js : javascript principale
- files/images : percorso di upload per foto prodotti
	
## Note

Ho cercato di utilizzare il più possibile le funzionalità messe a disposizione dal core di Symfony e da Doctrine, riducendo al minimo il codice e l'html custom.
Per le interfacce mi sono avvalso dell'integrazione tra Twig e Bootstrap.
Ho gestito il filtro sui tag a livello di pagina con jQuery.


