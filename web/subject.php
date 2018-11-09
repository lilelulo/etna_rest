<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>TIC - REST : API Restfull</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.5.0/styles/monokai-sublime.min.css">
		<link rel="stylesheet" href="https://intra.etna-alternance.net/css/sujet-html-prep-new.css">
	</head>
	<body>

		<!-- Paramètres du projet -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<i class="fa fa-cogs"></i>
				<h2>TIC - REST : API</h2>
			</div>
		</div>

		<!-- Attention -->
		<div class="panel panel-info">
			<div class="panel-heading">
				<i class="fa fa-exclamation-triangle"></i>
				<h3>Objectif du projet</h3>
			</div>
			<div class="panel-body">

			<div class="well well-sm">
				<p>
					Le but du projet est de conservoir une API REST autour du project Crownding que vous avez fait lors de l'UV TWEB.<br/>
					Vous avez pour voir une architecture MVC, mais aujourd'hui beaucoup de projet propose ou utilise une architecture centré sur des APIs, exemple des application mobile qui récupère des données via ce genre de solution.<br/>
					Vous devrez donc devoir fournir un enssemble de Endpoint pour que d'autre personne puisse utiliser votre Crowding
				</p>
				<p>
					Le choix de la techno est completmenet libre, vous pouvez donc partir sur du NodeJS ou du Java en passant par du Ruby ou rester sur du PHP, de la même manière les frameworks sont completement autoriser.<br/>
					Attention cependant dans ce projet aucune aide ne vous sera donnée sur la techno, donc si vous utiliez une techno que vous ne maitrisez pas pour faire un "teste" ce sera a vos risque et péril. 
				</p>
				<p>
					Le projet se concentrera sur l'API et pour perdre le moins de temps possible un fichier SQL avec une structure et des données de teste vous sera fourni.<br>
					Si vous avez envie de modifier la structure, c'est à vous de voir, mais pareil c'est à vos risque et péril.
				</p>

			</div>
			</div>
		</div>

		<!-- Attention -->
		<div class="panel panel-info">
			<div class="panel-heading">
				<i class="fa fa-exclamation-triangle"></i>
				<h3>Quest</h3>
			</div>
			<div class="panel-body">

			<div class="well well-sm">
				<ul>
					<li>Le quest comporte 13 étapes.</li>
					<li>Il ne faut pas finir juste 7 étapes pour valider le projet.</li>
					<li>Les étapes ont une interaction forte, donc pour valider l'étape 2 vous devez valider l'étape 1.</li>
					<li>La date de rendu du projet et la date limite pour valider les 13 étapes, pas uniquement la 1er.</li>
					<li>Aucune validation de sera faite la 1er semaine. Normalement la 1er semaine doit vous servir pour mettre en place le projet de facon la plus clean possible.</li>
				</ul>
			</div>
			</div>
		</div>

		<!-- Attention -->
		<div class="panel panel-info">
			<div class="panel-heading">
				<i class="fa fa-exclamation-triangle"></i>
				<h3>Validation</h3>
			</div>
			<div class="panel-body">

			<div class="well well-sm">
				<ul>
					<li>A chaque validation nous allons tester vos Endpoint</li>
					<li>Mais aussi des cas limites</li>
					<li>Avant chaque validation penser a faire un dump de la database avec le fichier SQL fournie, certaine donnée sont importante (les codes utilisateurs).</li>
				</ul>
			</div>
			</div>
		</div>


		<!-- Attention -->
		<div class="panel panel-danger">
			<div class="panel-heading">
				<i class="fa fa-exclamation-triangle"></i>
				<h3>Regle générique</h3>
			</div>
			<div class="panel-body">

			<div class="well well-sm">
				<ul>
					<li>Vos page 400, 404, ... dois renvoyé un json avec le bon code HTTP</li>
				</ul>
			</div>
			</div>
		</div>

		<!-- Attention -->
		<div class="panel panel-info">
			<div class="panel-heading">
				<i class="fa fa-exclamation-triangle"></i>
				<h3>Step 1 : GET : Domains</h3>
			</div>
			<div class="panel-body">

<div class="well well-sm">
curl -X "GET" /api/domains.json
</div>

<pre class="ace">
<code class="coding" data-mode="json">
{
	"code": 200,
	"message": "success",
	"datas": [
		{
			"id": 1,
			"slug": "mailer",
			"name": "mailer",
			"description": "Liste des mails automatisé"
		},
		{
			"id": 2,
			"slug": "documents",
			"name": "documents",
			"description": "un petit teste de documents a traduire."
		}
	]
}
</code>
</pre>
			</div>
		</div>

		<!-- Attention -->
		<div class="panel panel-info">
			<div class="panel-heading">
				<i class="fa fa-exclamation-triangle"></i>
				<h3>Step 2 : GET : Domain</h3>
			</div>
			<div class="panel-body">
<div class="well well-sm">
curl -X "GET" /api/domaines/mailer.json
</div>

<pre class="ace">
<code class="coding" data-mode="json">
{
	"code": 200,
	"message": "success",
	"datas": {
		"langs": [
			"EN",
			"FR",
			"PL"
		],
		"id": 1,
		"slug": "mailer",
		"name": "mailer",
		"description": "Liste des mails automatisé",
		"creator": {
			"id": 1,
			"username": "lilelulo"
		},
		"created_at": "2018-01-27T00:00:00+01:00"
	}
}
</code>
</pre>
			</div>
		</div>

		<!-- Attention -->
		<div class="panel panel-info">
			<div class="panel-heading">
				<i class="fa fa-exclamation-triangle"></i>
				<h3>Step 3 : GET : Domain > Translations</h3>
			</div>
			<div class="panel-body">

<div class="well well-sm">
curl -X "GET" /api/domains/mailer/translations.json
</div>

<pre class="ace">
<code class="coding" data-mode="json">
{
	"code": 200,
	"message": "success",
	"datas": [
		{
			"trans": {
				"EN": "hello",
				"FR": "bonjour",
				"PL": "__registration__"
			},
			"id": 1,
			"code": "__registration__"
		},
		{
			"trans": {
				"EN": "bye bye",
				"FR": "au revoir",
				"PL": "__bye__"
			},
			"id": 2,
			"code": "__bye__"
		},
		{
			"trans": {
				"EN": "5a6fa30b80f0e - EN",
				"FR": "5a6fa30b80f0e - FR",
				"PL": "_5a6fa30b80f0e__"
			},
			"id": 7,
			"code": "_5a6fa30b80f0e__"
		}
	]
}
</code>
</pre>
			</div>
		</div>

		<!-- Attention -->
		<div class="panel panel-success">
			<div class="panel-heading">
				<i class="fa fa-exclamation-triangle"></i>
				<h3>Step 4 : POST: Domain > Translation</h3>
			</div>
			<div class="panel-body">
<div class="well well-sm">
curl -X "POST" <br>
-d "code=test_3&trans[FR]=je+suis+un+test+fr&trans[EN]=i+m+a+test+en" <br>
-H "Content-type: application/form-data" <br>
-H "Authorization: ezygazkfuygezkfjgzkefj" <br>
/api/domains/mailer/translations.json
</div>


<pre class="ace">
<code class="coding" data-mode="json">
{
    "code": 200,
    "message": "success",
    "datas": {
        "trans": {
            "FR": "je suis un test fr",
            "EN": "i m a test en",
            "PL": "test"
        },
        "id": 140,
        "code": "test_3"
    }
}
</code>
</pre>

			</div>
		</div>


		<!-- Attention -->
		<div class="panel panel-warning">
			<div class="panel-heading">
				<i class="fa fa-exclamation-triangle"></i>
				<h3>Step 5 : PUT : Domain > Translation</h3>
			</div>
			<div class="panel-body">
<div class="well well-sm">
curl -X "PUT" <br>
-d "trans[PM]=je+parle+pas+polonais" <br>
-H "Content-type: application/form-data" <br>
-H "Authorization: ezygazkfuygezkfjgzkefj" <br>
/api/domains/mailer/translations.json
</div>


<pre class="ace">
<code class="coding" data-mode="json">
{
    "code": 200,
    "message": "success",
    "datas": {
        "trans": {
            "FR": "azef azef azefaz e",
            "EN": "test",
            "PL": "je parle pas polonais"
        },
        "id": 140,
        "code": "test"
    }
}
</code>
</pre>


</pre>
			</div>
		</div>

		<!-- Attention -->
		<div class="panel panel-danger">
			<div class="panel-heading">
				<i class="fa fa-exclamation-triangle"></i>
				<h3>Step 6 : DELETE : Domain > Transalation</h3>
			</div>
			<div class="panel-body">
<div class="well well-sm">
curl -X "DELETE"<br>
-H "authorization: ezygazkfuygezkfjgzkefj"
/api/domains/mailer/translations/140.json
</div>

<pre class="ace">
<code class="coding" data-mode="json">
{
	"code": 200,
	"message": "success",
	"datas": {
		"id": 140
	}
}
</code>
</pre>
			</div>
		</div>


		<!-- Attention -->
		<div class="panel panel-info">
			<div class="panel-heading">
				<i class="fa fa-exclamation-triangle"></i>
				<h3>Step 7 : GET : Domain > Translations (filter)</h3>
			</div>
			<div class="panel-body">
<div class="well well-sm">
curl -X "GET" <br>
/api/domains/mailer/translation.json?code=reg
</div>


<pre class="ace">
<code class="coding" data-mode="json">
{
	"code": 200,
	"message": "success",
	"datas": [
		{
			"trans": {
				"EN": "hello",
				"FR": "bonjour",
				"PL": "__registration__"
			},
			"id": 1,
			"code": "__registration__"
		},
		{
			"trans": {
				"EN": "not possible - EN",
				"FR": "pas possible - FR",
				"PL": "registration_fail"
			},
			"id": 7,
			"code": "registration_fail"
		}
	]
}
</code>
</pre>

			</div>
		</div>


		<!-- Attention -->
		<div class="panel panel-info">
			<div class="panel-heading">
				<i class="fa fa-exclamation-triangle"></i>
				<h3>Step 8 : GET : Domain</h3>
			</div>
			<div class="panel-body">
<div class="well well-sm">
curl -X "GET" <br>
-H "Authorization: ezygazkfuygezkfjgzkefj" <br>
/api/domaines/mailer.json
</div>

<pre class="ace">
<code class="coding" data-mode="json">
{
	"code": 200,
	"message": "success",
	"datas": {
		"langs": [
			"EN",
			"FR",
			"PL"
		],
		"id": 1,
		"slug": "mailer",
		"name": "mailer",
		"description": "Liste des mails automatisé",
		"creator": {
			"id": 1,
			"username": "lilelulo",
			"email": "lilelulo@tipeee.com"
		},
		"created_at": "2018-01-27T00:00:00+01:00"
	}
}
</code>
</pre>
			</div>
		</div>

		<!-- Attention -->
		<div class="panel panel-success">
			<div class="panel-heading">
				<i class="fa fa-exclamation-triangle"></i>
				<h3>Step 9 : POST : Domain</h3>
			</div>
			<div class="panel-body">
<div class="well well-sm">
curl -X "POST" <br>
-d "name=new+domain&description=short+description&lang[]=EN&lang[]=FR" <br>
-H "Content-type: application/form-data" <br>
-H "Authorization: ezygazkfuygezkfjgzkefj" <br>
/api/domains.json
</div>


<pre class="ace">
<code class="coding" data-mode="json">
{
	"code": 200,
	"message": "success",
	"datas": {
		"langs": [
			"EN",
			"FR"
		],
		"id": 4,
		"slug": "new-domain",
		"name": "new domain",
		"description": "short description",
		"creator": {
			"id": 1,
			"username": "lilelulo",
			"email": "lilelulo@tipeee.com"
		},
		"created_at": "2018-01-27T00:00:00+01:00"
	}
}
</code>
</pre>

			</div>
		</div>

		<!-- Attention -->
		<div class="panel panel-danger">
			<div class="panel-heading">
				<i class="fa fa-exclamation-triangle"></i>
				<h3>Step 10 : DELETE : Domain > Lang</h3>
			</div>
			<div class="panel-body">
<div class="well well-sm">
curl -X "DELETE" <br>
-H "Content-type: application/form-data" <br>
-H "Authorization: ezygazkfuygezkfjgzkefj" <br>
/api/domains/new-domain/lang/EN.json
</div>


<pre class="ace">
<code class="coding" data-mode="json">
{
	"code": 200,
	"message": "success",
	"datas": {
		"langs": [
			"FR"
		],
		"id": 4,
		"slug": "new-domain",
		"name": "new domain",
		"description": "short description",
		"creator": {
			"id": 1,
			"username": "lilelulo",
			"email": "lilelulo@tipeee.com"
		},
		"created_at": "2018-01-27T00:00:00+01:00"
	}
}
</code>
</pre>

			</div>
		</div>


<!-- Attention -->
		<div class="panel panel-info">
			<div class="panel-heading">
				<i class="fa fa-exclamation-triangle"></i>
				<h3>Step 11 : GET : Langs</h3>
			</div>
			<div class="panel-body">
<div class="well well-sm">
curl -X "GET" <br>
/api/langs.json?page=2&per_page=3&sort=desc
</div>


<pre class="ace">
<code class="coding" data-mode="json">
{
	"code": 200,
	"message": "success",
	"datas": [
		"ES",
		"EN",
		"AF"
	]
}
</code>
</pre>

			</div>
		</div>


<!-- Attention -->
		<div class="panel panel-info">
			<div class="panel-heading">
				<i class="fa fa-exclamation-triangle"></i>
				<h3>Step 12 : GET : Domain > Download</h3>
			</div>
			<div class="panel-body">
<div class="well well-sm">
curl -X "GET" <br>
/api/domains/mailer.xliff
</div>


<pre class="ace">
<code class="coding" data-mode="json">
mailer-20180101-120000.xliff
</code>
</pre>

			</div>
		</div>

		<!-- Attention -->
		<div class="panel panel-info">
			<div class="panel-heading">
				<i class="fa fa-exclamation-triangle"></i>
				<h3>Step 13 : Default format</h3>
			</div>
			<div class="panel-body">
				Vous devez revoir tout vos url pour mettre un format par défaut, c'est a dire que <br>
				curl -X "GET" /api/domains/mailer/translations.json === curl -X "GET" /api/domains/mailer/translations<br>
				et que par defaut le format renvoyé est du json
			</div>
		</div>

  <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.5/ace.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.6.0/highlight.min.js"></script>
  <script>
    $(function() {
      // Highlight js
      $( "code" ).each( function( i, block ) {
        hljs.highlightBlock( block );
      });
      // Ace editor
      const ids = $( ".coding" );
          var jqPre = $( ".ace" );

      for ( var idi = 0; idi < ids.length; idi++ ) {
        var	id = ids[ idi ],
          editor = ace.edit( id ),
          jqEditor = $( id ),
          mode = jqEditor.attr( "data-mode" ),
          fontSize = 12,
          lineHeight = 16,
          lines = editor.session.getLength();
        ;

        // Settings for the editor
        editor.getSession().setMode( "ace/mode/" + mode );
        editor.setTheme( "ace/theme/monokai" );
        editor.setReadOnly( true );
        editor.setHighlightActiveLine( true );
        editor.setShowPrintMargin( false );

        // Set the div size
        jqEditor.css({
          "font-size": fontSize + "px",
          "line-height": lineHeight + "px",
          "height": ( lineHeight * lines ) + "px"
        });
      }
        jqPre.css( "background-color", "#272822" ) // Monokai theme background
    });
  </script>
				<script type="text/javascript">
$('.oauth-test').on('click', function(){
  window.open ("http://192.168.109.129:8000/oauth/v2/auth?client_id=4_2x6cwx2s08iskc40wgogg4wcg8c8s00ckgo8s8wg0gg8wwggg8&redirect_uri=http%3A//192.168.109.129%3A8000/get-token&response_type=code","mywindow", "width=350,height=250");
  // Create IE + others compatible event handler
  var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
  var eventer = window[eventMethod];
  var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";
  // Listen to message from child window
  eventer(messageEvent,function(e) {
    console.log('origin: ', e.origin)
    console.log('parent received message!: ', e.data);
  }, false);
});
  </script>
  </body>
</html>
