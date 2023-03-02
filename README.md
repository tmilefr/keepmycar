# codeignter_implement
Implémentation de codeignter pour une application web - codeigniter 3 / bootstrap 4 - 

## What is CodeIgniter?
Codeigniter est un PHP full-stack web framework ( léger, rapide, flexible et secure )
Plus d'information sur le  [site officiel](http://codeigniter.com).

## Qu'es que SASGWA - Simple And Stupid Generic Web App ? 

C'est mon humble vision de la construction d'une application web sur le framework CodeIgniter. 

Ce qu'il n'y a pas :

- Une gestion de menu ( qui change sont menu 100 fois dans une application ? )
- Une gestion des droits 
- Une gestion des erreurs
- Tous ce qui fait une UI moderne ( lazy loading, interaction ... )
- ...

Ce qu'il y a :

- Schéma JSON => Core DataModel => Core Controller => Objet de rendu => Vue.
- Des objets de rendu utilisable dans des vues

```
codeignter_implement/
└── application/
    ├── core/
    │   └── MY_Controller.php => Core Controlleur (essentiellement un CRUD)
    ├── libraries
    │	├── Bootstrap_tools.php => implémentation de bootstrap dans le rendu.
    │   └── Render_object.php => Objet de Rendu utilisé pour générer un élement ( de formulaire, de liste, de vue ... )
    ├── models/
    │   ├── json
	│	│	├── XXX.json => Définition de la table 
	│	│	└── XXX_data.json => Donnée d'exemple chargé par la migration de codigniter ( voir migrations/001_setup.php)
    │   └── Core_model.php
    └── views
		├── list_view.php => vue en liste classique
		├── edtion
		│	└── XXXX_form.php => edition de la vue XXX (adaptable et simple !)
		└── unique
			└── XXXX_view.php => vue complète d'un élement XXX (adaptable et simple !)
```

## Installation & lancement

```sql
//Creation de la base de donnée app
CREATE SCHEMA `app` ;

//Création de la table de session
Création de la base Mysql
CREATE TABLE IF NOT EXISTS `ci_sessions` (
	`id` varchar(128) NOT NULL,
	`ip_address` varchar(45) NOT NULL,
	`timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
	`data` blob NOT NULL,
	KEY `ci_sessions_timestamp` (`timestamp`)
);
ALTER TABLE ci_sessions ADD PRIMARY KEY (id, ip_address);
```
		
```php
Changement de la config dans /application/config/database
/*
	'hostname' => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => 'app',
*/
```
Adaptation du .htaccess et de la configuration $config['base_url']

Lancement http://localhost/codeignter_implement/setup.

Une application test avec un jeux de donnée de test est alors disponible.

### Documentation

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

## Vue d'un element  (exemple partiel)

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



