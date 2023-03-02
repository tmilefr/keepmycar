
# Documentation

## Arboresence

```js
codeignter_implement/
└── application/
    ├── core/
    │   └── MY_Controller.php => Core Controlleur (essentiellement un CRUD)
    ├── libraries
	│	├── Render_object.php (factory)
    │	├── Form_validation.php (override core Form_validation)
	│	├── Acl.php (auth)
    │	├── Bootstrap_tools.php => implémentation de bootstrap dans le rendu.
    │   ├── Render_object.php => Objet de Rendu utilisé pour générer un élement ( de formulaire, de liste, de vue ... )
	│   └── Elements
	│   	    └──── xxx.php (element)
    ├── models/
    │   ├── json
	│	│	├── XXX.json => Définition de la table 
	│	│	└── Menu.json => Menu
    │   ├── Acl_users_model.php ( model implement )
    │   └── Core_model.php
	│
    └── views
		├── template
		│	├── head.php
		│	└── footer.php
		├── edtion
		│	└── XXXX_form.php => edition de la vue XXX
		└── unique
			├── XXXX_view.php => vue complète d'un élement XXX 
			└── list_view.php => vue en liste classique
```

## Controlleur

```php
class Users_controller extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->_controller_name = 'Users_controller';		//controller name for routing
		$this->_model_name 		= 'Users_model';	   		//DataModel
		$this->_edit_view 		= 'edition/Users_form';		//Vue d'édition
		$this->_list_view		= 'unique/Users_view.php';  //Vue de rendu d'un élément
		$this->_autorize 		= array('add'=>true,'edit'=>true,'list'=>true,'delete'=>true,'view'=>true); //Vue activée

		$this->title .= ' - '.$this->lang->line($this->_controller_name); //pour spécialiser la page.
		$this->init(); //lancement.
	}

}
```

## Model

Acl_users_model.php
```php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(dirname(__FILE__).'/Core_model.php');

class Acl_users_model extends Core_model{
	
	function __construct(){
		parent::__construct();
		$this->_set('table'	, 'acl_users');
		$this->_set('key'	, 'id');
		$this->_set('order'	, 'name');
		$this->_set('direction'	, 'desc');
		$this->_set('json'	, 'Acl_users.json');
		$this->_init_def();
	}

}
```

## Schéma Json d'une table (exemple partiel)

```json
{
	"id": {
		"type": "hidden",
		"list": true,
		"search": false,
		"rules": null,
		"since": 1,
		"dbforge": {
			"type": "INT",
			"constraint": "11",
			"unsigned": true,
			"auto_increment": true
		}
	},
	"name": {
		"type": "input",
		"list": true,
		"search": true,
		"rules": "trim|required|min_length[5]|max_length[255]",
		"since": 1,
		"dbforge": {
			"type": "VARCHAR",
			"constraint": "255"
		}
	},
	"section": {
		"type": "select",
		"list": true,
		"search": false,
		"rules": null,
		"since": 1,
		"values": {
			"1": "Motonautisme",
			"2": "Ski",
			"3": "Voile",
			"4": "Wake"
		},
		"dbforge": {
			"type": "INT",
			"constraint": "5"
		}
	},
	"family": {
		"type": "select_database",
		"list": true,
		"search": false,
		"rules": null,
		"since": 2,
		"values": "distinct(family,id:name)",
		"dbforge": {
			"type": "INT",
			"constraint": "5"
		}
	}	
}
```

## Vue d'édtion  (exemple partiel)

```html
<div class="container-fluid">
<?php
echo form_open('Users_controller/add', array('class' => '', 'id' => 'edit') , array('form_mod'=>$form_mod,'id'=>$id) );

echo form_error('name', 	'<div class="alert alert-danger">', '</div>');
?>
<div class="form-row">
	<div class="form-group col-md-4">
		<?php 
			echo $this->bootstrap_tools->label('name');
			echo $this->render_object->RenderFormElement('name'); 
		?>
	</div>
</div>
<button type="submit" class="btn btn-primary"><?php echo Lang($form_mod.'_'.$this->router->class);?></button>
<?php
echo form_close();
?>
</div>
```

## rendu d'un element  (exemple partiel)

```html
<div class="card">
	  <div class="card-header">
		<?php echo $this->render_object->RenderElement('name').' '.$this->render_object->RenderElement('surname');?> / <?php echo $this->render_object->RenderElement('family');?>
	  </div>
	  <div class="card-body">
		<h5 class="card-title">
			<?php 
				echo $this->render_object->RenderElement('email'); 
			?>
		</h5>
	  </div>
</div>
```

## Objets
### element.php
```json
	"name": {
		"type": "element",
		"list": true/false, // in list view
		"search": true/false,// integrate in global search 
		"rules": "trim|required|min_length[2]|max_length[255]", //see form validation 
		"since": 1,
		"dbforge": {
			"type": "VARCHAR",
			"constraint": "255"
		}
	},
```

### element_captcha.php

param re-captcha

```php 
secured.php
CONST SITE_CAPTCHA_KEY = '';
CONST SITE_CAPTCHA_SECRET_KEY = '';
CONST SITE_CAPTCHA_URL = 'https://www.google.com/recaptcha/api/siteverify';

$config['captcha'] = TRUE/FALSE;
```

### element_check.php

### element_checkbox.php

### element_checkboxdb.php
Un objet checkbox en relation avec une liste dans une table

#### definition
```json
	"sql" : "ALTER TABLE `famille` ADD `capacity` VARCHAR(255) NULL AFTER `ecole`;",
	"type": "checkboxdb",
	"list": false,
	"search": false,
	"rules": null,
	"param":"distinct(options,cle:value#filter=capacity)", //clés,valeures pour les checkbox
	"values":[],
	"model": "Capacity_model",
	"ref":"id_cap",
	"foreignkey":"id_fam",		
	"since": 1,
	"dbforge": {
		"type": "VARCHAR",
		"constraint": "255"
	}
```

### element_created.php
date time pour les traces
```json
	"created": {
		"type": "created",
		"list": false,
		"search": false,
		"rules": null,
		"since": 1,
		"dbforge": {
			"type": "DATETIME"
		}
	},
```

### element_date.php

### element_file.php

### element_html.php

### element_memo.php

### element_month.php

### element_password.php

### element_select_database.php

### element_select.php

### element_service.php

### element_table.php
```json
"e_mail_comp": {
		"type": "table",
		"link" : "",
		"sql":"ALTER TABLE `famille` ADD `e_mail_comp` VARCHAR(255) NULL AFTER `e_mail`;", //infos
		"list": false,
		"search": false,
		"rules": "trim",
		"since": 1,
		"model": "Email_model", //model à utiliser
		"ref":"email", //champ de reference
		"foreignkey":"id_fam", //lien entre les tables maire et secondaire.
		"dbforge": {
			"type": "VARCHAR",
			"constraint": "255"
		}
	},	
```

### element_time.php

### element_typeahead.php

### element_updated.php
date time pour les traces
```json
	"updated": {
		"type": "updated",
		"list": false,
		"search": false,
		"rules": null,
		"since": 1,
		"dbforge": {
			"type": "DATETIME"
		}
	}
```

## Git Flow :

develop est rattaché à l'environnement https://regio.dev-asso.fr
main est rattaché à l'environnement https://mulhouse-travaux.abcmzwei.eu/

branches de feature "feature-xxx" à partir de "develop" et faire une demande de merge c'est quand fini
Ensuite, on met à jour l'environnement regio pour tester (git deploy sur le serveur )
sur notre validation, on pousse en prod (git deploy sur le serveur)

Pour les hotfix, branche de hotfix "hotfix-xxx" à partir de "main", et cherry pick sur main après validation sur la production.