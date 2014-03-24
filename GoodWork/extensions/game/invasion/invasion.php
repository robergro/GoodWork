<style type="text/css">

#titreGame{
}
	
#dvg_jeux{
	/*background-image:url("../game/invasion/res/fond.jpg");*/
	position:absolute;
	margin-top: -80px;
	margin-bottom: 10%;
	height:97%;

	width:80%;
	overflow:hidden;
	margin-left:5%;
	margin-right:5%;
	top: 100px;
}
	
#menu{	
	background-color:rgba(250,250,250,0.2);
	height:60%;
	width:80%;
	margin:auto;
	margin-top:10%;
	border-style: solid;
	border-color: rgba(250,250,250,0.5);
	border-width: 1px;
	color:white;
}
	
#menu div{
	height:20%;
	width:100%;
	cursor:pointer;
	position:relative;
	font-size:20px;
	border-style: solid;
  	border-color: rgba(250,250,250,0.5);
  	border-width: 1px;
}

#menu div:hover{
	color: rgba(0,0,0,0.1);
}


#dg_point{
	float:left;
}

#dg_point span{
	color:#DEDDDD;
	font-size:20px;
}

.game_over{
	background:black;
	opacity:0.6;
	filter: alpha(opacity = 60);
	text-align:center;
	padding-top:50px;
	color:white;
	font-size:80px;
	top:30px;
	height:70%;
	width:90%;
	position: absolute;
	top:0;
	left: 0;
	cursor:pointer;
}
	</style>
<script type="text/javascript">

var k_jeux_a={

	hero:null,
	tbcibleH:[],
	tbcibleV:[],
	tb_mechant:[],
	tbelement_tir_H:[],
	tbelement_tir_V:[],
	tbelement_tir:[],
	temp:null,
	plus_interv:null,
	intev_duree:null,
	time_boum:null,
	hero_toucher:null,
	mode:null,
	nbr_de_vie:0,
	timer_init:null,
	mode_laser:'man',
	stop_laser:null,
	duree_partie:120,
	clone1:null,
	clone2:null,
	fn_fin:null,
	point:0,
	vie_gagne:500,
	bonus:'non',
	bonus_point:800,
	son_vie_gagne:null,
	son_bonus:null,
	score:0,
	
	creason:function(chemin){
		
		var audio_el=document.createElement('audio');
		
		var s_ogg=document.createElement('source');
		s_ogg.setAttribute('type','audio/ogg');
		s_ogg.setAttribute('src',chemin+'.ogg');
		audio_el.appendChild(s_ogg);
		
		var s_mp3=document.createElement('source');
		s_mp3.setAttribute('type','audio/mp3');
		s_mp3.setAttribute('src',chemin+'.mp3');
		audio_el.appendChild(s_mp3);
		return audio_el;
	}
	
}


function moi(){  //objet vaisseau du hero

	this.elem=document.createElement('img');
	this.elem.src='extensions/game/invasion/res/ship.png';
	this.elem.style.position='absolute';
	this.elem.style.cursor='url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAgY0hSTQAAeiYAAICEAAD6AAAAgOgAAHUwAADqYAAAOpgAABdwnLpRPAAAAAlwSFlzAAAOwwAADsMBx2+oZAAAABl0RVh0U29mdHdhcmUAUGFpbnQuTkVUIHYzLjUuND6NzHYAAAALSURBVBhXY2AAAgAABQABqtXIUQAAAABJRU5ErkJggg==),pointer';
	document.getElementById('dvg_jeux').appendChild(this.elem);

	k_jeux_a.tbcibleH.push(0);
	this.posi_tb=0;
	this.time=setInterval(v_alien_v_ami,20);
	k_jeux_a.plus_interv=setInterval(plus_plus,10000);
}



function mechant(){		//objet des soupes

	this.elem=document.createElement('img');
	this.elem.src='extensions/game/invasion/res/invader.png';
	this.elem.style.position='absolute';
	document.getElementById('dvg_jeux').appendChild(this.elem);
	
	this.aud=k_jeux_a.creason('extensions/game/invasion/res/son/explosion');
	
	k_jeux_a.tbcibleH.push(0);
	this.posi_tb=k_jeux_a.tb_mechant.length;
	this.vitesse=20;
	this.px_vitesse=4;
	
	this.init_envahisseur();
	var that=this;
	this.time=setInterval(function(){that.bouge(that)},that.vitesse);
	this.time_accident='';
}


mechant.prototype.bouge=function(that){		//deplacement des soupes

	var el=that.elem;
	var conteneur=document.getElementById('dvg_jeux');

	el.style.left=k_jeux_a.tbcibleH[that.posi_tb]+'px';

	if(k_jeux_a.tbcibleH[that.posi_tb] > conteneur.offsetWidth){
		this.init_envahisseur();
	}
	k_jeux_a.tbcibleH[that.posi_tb]+=that.px_vitesse;

}


mechant.prototype.init_envahisseur=function(){		//positionnement des soupes dans la page au demarrage du jeux et en cour de jeux.

	var el=this.elem;
	
	if(k_jeux_a.bonus=='ok'){
	el.src='extensions/game/invasion/res/bonus.png';
	k_jeux_a.bonus='non';
	}
	else{
	el.src='extensions/game/invasion/res/invader.png';
	}

	var haut_max=50;		//position en hauteur mini des soucoupe par rapport au bas de la page

	var conteneur=document.getElementById('dvg_jeux');

	var posi_haut=Math.round(Math.random()*(conteneur.offsetHeight-haut_max));

	k_jeux_a.tbcibleH[this.posi_tb]=0-el.offsetWidth;
	k_jeux_a.tbcibleV[this.posi_tb]=posi_haut;

	el.style.left=k_jeux_a.tbcibleH[this.posi_tb]+'px';
	el.style.top=k_jeux_a.tbcibleV[this.posi_tb]+'px';

}

mechant.prototype.son_explosion=function(){

	if (typeof window.addEventListener != 'undefined'){
		this.aud.currentTime=0;
		this.aud.play();
		}
}



function clic_tir(evt){		//gestion du nombres de rayons laser

	for(var i = 0; i < k_jeux_a.tbelement_tir.length; i++){

		var elem_display=k_jeux_a.tbelement_tir[i].elem.style.display;

		if(elem_display=='none'){
			
			k_jeux_a.tbelement_tir[i].init_tir(evt);
			
			break;
		}
	}
	if(k_jeux_a.mode_laser=='auto'){
		k_jeux_a.stop_laser=setTimeout(evt_creation,120);
	}	
}


function evt_creation(){		// laser auto
	if (typeof window.addEventListener != 'undefined'){
		var mousedownEvent = document.createEvent ("MouseEvent");
		mousedownEvent.initMouseEvent ("mousedown", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
		document.dispatchEvent(mousedownEvent);
	}
	
	else if (document.createEventObject) {   // IE < 9
		var mousedownEvent = document.createEventObject();
		mousedownEvent.button = 1;
		document.fireEvent ("onmousedown", mousedownEvent);
	}
	
}


function arret_laser(){

	if(k_jeux_a.mode_laser=='auto'){
		clearTimeout(k_jeux_a.stop_laser);
	}
}


function objet_tir(){		//objet des rayons laser

	this.elem=document.createElement('img');
	this.elem.src='extensions/game/invasion/res/lazer.png';
	this.elem.style.display='none';
	this.elem.style.position='absolute';
	document.getElementById('dvg_jeux').appendChild(this.elem);

	this.aud=k_jeux_a.creason('extensions/game/invasion/res/son/laser_04');
	
	this.posi_tb=k_jeux_a.tbelement_tir.length;
	k_jeux_a.tbelement_tir_V.push(0);
	this.timeout='';

}


objet_tir.prototype.init_tir=function(evt){		//positionnement des rayons laser par rapport au vaisseau du hero

	typeof window.addEventListener == 'undefined' ? event.returnValue = false : evt.preventDefault();

	k_jeux_a.tbelement_tir_V[this.posi_tb]=k_jeux_a.hero.elem.offsetTop;

	this.elem.style.top=k_jeux_a.tbelement_tir_V[this.posi_tb]+'px';
	this.elem.style.left=k_jeux_a.hero.elem.offsetLeft+(k_jeux_a.hero.elem.offsetWidth/2)+'px';

	this.elem.style.display='block';
	this.son_tir();
	this.tir(this);
}

objet_tir.prototype.son_tir=function(){

	if (typeof window.addEventListener != 'undefined'){
	this.aud.currentTime=0;
	this.aud.play();
	}
}


objet_tir.prototype.tir=function(that){		//gestion du rayon laser quand il touche une soupe

	var el=that.elem;

	for(var i = 0; i < k_jeux_a.tb_mechant.length; i++){

		var el2=k_jeux_a.tb_mechant[i].elem;

		if(el2.src.indexOf('boum.png')!=-1){
		continue;
		}
		
		el.style.top=k_jeux_a.tbelement_tir_V[that.posi_tb]+'px';

		if(colision(that,k_jeux_a.tb_mechant[i],i)){

			k_jeux_a.tbelement_tir_V[that.posi_tb]=0;
			
			k_jeux_a.tb_mechant[i].son_explosion();
			
			point(5);		//5 est le nombres de points quand une soucoupe est touch�
			
			
			if(el2.src.indexOf('bonus.png')!=-1){
			moins_moins();
			}
			
			
			el2.src='extensions/game/invasion/res/boum.png';
			k_jeux_a.time_boum=setTimeout(function(){k_jeux_a.tb_mechant[i].init_envahisseur()},200);
			
			el.style.display='none';
			return false;
		}

		if(k_jeux_a.tbelement_tir_V[that.posi_tb] < 0){
			el.style.display='none';
			return false;
		}
		
	}	
	
	k_jeux_a.tbelement_tir_V[that.posi_tb]-=8;
	that.timeout=setTimeout(function(){that.tir(that)},20);
}



function colision(obj1,obj2,tb_position){		//gestion de la colision entre les laser et les soupes

	var el=obj1.elem;
	var el2=obj2.elem;

	return(k_jeux_a.tbelement_tir_V[obj1.posi_tb] < el2.offsetTop+el2.offsetHeight && k_jeux_a.tbelement_tir_V[obj1.posi_tb] > el2.offsetTop && el.offsetLeft > k_jeux_a.tbcibleH[tb_position] && el.offsetLeft < k_jeux_a.tbcibleH[tb_position]+el2.offsetWidth);
}



function v_alien_v_ami(){		//gestion de la colision entre les aliens et le vaisseau du hero

	for(var i = 0; i < k_jeux_a.tb_mechant.length; i++){

		var obj1=k_jeux_a.hero;
		var obj2=k_jeux_a.tb_mechant[i];
		var el=obj1.elem;
		var el2=obj2.elem;


		if (obj2.elem.src.indexOf('boum.png')==-1){
			
			if(el.offsetTop < el2.offsetTop+el2.offsetHeight && el.offsetTop+el.offsetHeight > el2.offsetTop && el.offsetLeft+el.offsetWidth > k_jeux_a.tbcibleH[i] && el.offsetLeft < k_jeux_a.tbcibleH[i]+el2.offsetWidth){
				
				if(el2.src.indexOf('bonus.png')!=-1){
				moins_moins();
				}
				
				accident(i);
			}
		}
	}
}


function accident(i){		//gestion de la colision entre les aliens et le vaisseau du hero
	
	if(k_jeux_a.mode=='vie'){
		
		if(k_jeux_a.nbr_de_vie==3){
			k_jeux_a.nbr_de_vie=0;
			k_jeux_a.vie_gagne=500;
			raz_partie();
			return false;
		}
		
		k_jeux_a.nbr_de_vie++;
		document.getElementById('nbr_vie').firstChild.nodeValue=3-k_jeux_a.nbr_de_vie;
		
	}
	
	k_jeux_a.hero.elem.src='extensions/game/invasion/res/ship_touche.png';
	k_jeux_a.hero_toucher=setTimeout(function(){k_jeux_a.hero.elem.src='extensions/game/invasion/res/ship.png'},400);
	
	k_jeux_a.tb_mechant[i].elem.src='extensions/game/invasion/res/boum.png';
	k_jeux_a.tb_mechant[i].time_accident=setTimeout(function(){k_jeux_a.tb_mechant[i].init_envahisseur()},200);
	point(-20)//-20 correspond au nombre de points en moins quand le vaisseau touche une soucoupe
}


function suivre(event){		//gestion de la position du vaisseau du hero par rapport a la souris et aux bords du div conteneur.

	var conteneur=document.getElementById('dvg_jeux');
	var obj=k_jeux_a.hero.elem;
	var dde=(navigator.vendor) ? document.body : document.documentElement;
	
	if(event.clientX+(obj.offsetWidth/2)-conteneur.offsetLeft > conteneur.offsetWidth){
		obj.style.left=conteneur.offsetWidth-obj.offsetWidth+'px';
	}
	else if(event.clientX -(obj.offsetWidth/2) - conteneur.offsetLeft< 0){
		obj.style.left=0+'px';
	}
	else{
		obj.style.left=event.clientX-(obj.offsetWidth/2)-conteneur.offsetLeft+'px';
	}

	
	if(event.clientY-conteneur.offsetTop < conteneur.offsetTop){
		obj.style.top=0+'px';
	}

	else if(event.clientY+(obj.offsetHeight/2)-conteneur.offsetTop + dde.scrollTop > conteneur.offsetHeight){
		obj.style.top=conteneur.offsetHeight-obj.offsetHeight+'px';
	}
	else{
		obj.style.top=event.clientY-(obj.offsetHeight/2)-conteneur.offsetTop+ dde.scrollTop+'px';
	}

}


function c_parti(lui,mode){		//commencer la partie

	k_jeux_a.mode=mode;
	if(mode=='vie'){
	document.getElementById('nbr_vie').firstChild.nodeValue=3;
	}
	else{
	document.getElementById('nbr_vie').firstChild.nodeValue=0;
	}
	lui.parentNode.style.display='none';
	init();
	k_jeux_a.temp=new Date().getTime();
	duree();
}


function duree(){		//duree d'une partie

	if(k_jeux_a.mode=='vie'){
	return false;
	}

	var date=new Date().getTime();
	var sec = (date - k_jeux_a.temp) / 1000;
	
	if(sec>=k_jeux_a.duree_partie){
		raz_partie();
		return false;
	}
	
	var mn=Math.floor((k_jeux_a.duree_partie-sec)/60);
	var sc=Math.floor((k_jeux_a.duree_partie-sec)%60);
	sc=sc < 10 ? '0'+sc : sc;
	
	document.getElementById('tmp').firstChild.nodeValue='0'+mn+':'+sc;
	
	k_jeux_a.intev_duree=setTimeout(duree,1000);
}


function point(nbr){		//gestion et affichage des points

	k_jeux_a.point+=nbr;
	document.getElementById('point').firstChild.nodeValue=k_jeux_a.point;
	vie_gagne();
	bonus();
	
}


function vie_gagne(){

	if(k_jeux_a.mode=='vie' && k_jeux_a.point>=k_jeux_a.vie_gagne){
		k_jeux_a.vie_gagne+=500;
		k_jeux_a.nbr_de_vie--;
		document.getElementById('nbr_vie').firstChild.nodeValue=3-k_jeux_a.nbr_de_vie;
		k_jeux_a.son_vie_gagne.play();
	}
}


function bonus(){

if(k_jeux_a.point>=k_jeux_a.bonus_point){

		k_jeux_a.bonus_point+=800;
		k_jeux_a.bonus='ok';
	}

}


function plus_plus(){		//ajout d'une soupe tous les x temps

	if(k_jeux_a.mode=='ennemy'){
		k_jeux_a.tb_mechant.push(new mechant());
		k_jeux_a.tb_mechant.push(new mechant());
	}
	
	if(k_jeux_a.mode=='vitesse' || k_jeux_a.mode=='double'){
		
		for(var i = 0; i < k_jeux_a.tb_mechant.length; i++){
			k_jeux_a.tb_mechant[i].px_vitesse++;
		}
	}
	
	if(k_jeux_a.mode=='double' || k_jeux_a.mode=='vie'){
		k_jeux_a.tb_mechant.push(new mechant());
	}
	
	if(k_jeux_a.mode=='vie'){
		
		for(var i = 0; i < k_jeux_a.tb_mechant.length; i++){
			k_jeux_a.tb_mechant[i].px_vitesse+=0.5;
		}
	}
}


function moins_moins(){		//bonus tous les x temps

	k_jeux_a.son_bonus.play();

	if(k_jeux_a.mode=='ennemy'){
	
	var taille=k_jeux_a.tb_mechant.length-1;
	
	for(var i = taille; i >= taille-7; i--){
		
		var el=k_jeux_a.tb_mechant[i].elem;
		clearInterval(k_jeux_a.tb_mechant[i].time);
		delete k_jeux_a.tb_mechant[i];
		el.parentNode.removeChild(el);
		k_jeux_a.tb_mechant.pop();
		k_jeux_a.tbcibleH.pop();
		k_jeux_a.tbcibleV.pop();
	}
	}
	
	if(k_jeux_a.mode=='vitesse' || k_jeux_a.mode=='double'){
		
		for(var i = 0; i < k_jeux_a.tb_mechant.length; i++){
			k_jeux_a.tb_mechant[i].px_vitesse=k_jeux_a.tb_mechant[i].px_vitesse-2;
		}
	}
	
	if(k_jeux_a.mode=='double' || k_jeux_a.mode=='vie'){
	
		var taille=k_jeux_a.tb_mechant.length-1;
	
	for(var i = taille; i >= taille-4; i--){
		
		var el=k_jeux_a.tb_mechant[i].elem;
		clearInterval(k_jeux_a.tb_mechant[i].time);
		delete k_jeux_a.tb_mechant[i];
		el.parentNode.removeChild(el);
		k_jeux_a.tb_mechant.pop();
		k_jeux_a.tbcibleH.pop();
		k_jeux_a.tbcibleV.pop();
	}
	}
	
	if(k_jeux_a.mode=='vie'){
		
		for(var i = 0; i < k_jeux_a.tb_mechant.length; i++){
			k_jeux_a.tb_mechant[i].px_vitesse=k_jeux_a.tb_mechant[i].px_vitesse-2;
		}
	}
}



function raz_partie(){

	k_jeux_a.bonus_point=800;

	clearInterval(k_jeux_a.plus_interv);
	clearInterval(k_jeux_a.hero.time);
	clearTimeout(k_jeux_a.time_boum);
	clearTimeout(k_jeux_a.hero_toucher);
	
	for(var i = k_jeux_a.tb_mechant.length-1; i >= 0; i--){
		
		clearInterval(k_jeux_a.tb_mechant[i].time);
		
		delete k_jeux_a.tb_mechant[i];
		
		k_jeux_a.tb_mechant.pop();
		k_jeux_a.tbcibleH.pop();
		k_jeux_a.tbcibleV.pop();
	}
	
	for(var i = k_jeux_a.tbelement_tir.length-1; i >= 0; i--){
		
		clearTimeout(k_jeux_a.tbelement_tir[i].timeout);
		
		delete k_jeux_a.tbelement_tir[i];
		
		k_jeux_a.tbelement_tir_H.pop();
		k_jeux_a.tbelement_tir_V.pop();
		k_jeux_a.tbelement_tir.pop();

	}
	
	typeof window.addEventListener == 'undefined' ? document.detachEvent("onmousemove",suivre) : removeEventListener("mousemove",suivre, false);
	typeof window.addEventListener == 'undefined' ? document.detachEvent("onmousedown",clic_tir) : removeEventListener("mousedown",clic_tir, false);
	
	delete k_jeux_a.hero;
	
	if(k_jeux_a.point > k_jeux_a.score && k_jeux_a.mode=='vie'){
		k_jeux_a.score = k_jeux_a.point;
		localStorage.score1=k_jeux_a.score;
	}
		
	menu_fin();
}

function menu_fin(){
	
	k_jeux_a.clone1=document.getElementById('menu').cloneNode(true);
	k_jeux_a.clone2=document.getElementById('dg_point').cloneNode(true);
	k_jeux_a.clone1.style.display='block';
	
	var el=document.createElement('div');
	el.className='game_over';
	var txt=document.createTextNode('fin de partie');
	el.appendChild(txt);
	var s_ligne=document.createElement('br');
	el.appendChild(s_ligne);
	var txt2=document.createTextNode('score:'+k_jeux_a.point);
	el.appendChild(txt2);
	
	if(k_jeux_a.mode=='vie'){
	
	var s_ligne=document.createElement('br');
	el.appendChild(s_ligne);
	var txt3=document.createTextNode('meilleur score:'+k_jeux_a.score);
	el.appendChild(txt3);
	}
	
	k_jeux_a.fn_fin=document.getElementById('dvg_jeux').appendChild(el);
	
	setTimeout(function(){k_jeux_a.fn_fin.onclick=affiche_menu;},2000);
}

function affiche_menu(){
	document.getElementById('dvg_jeux').innerHTML='';
	document.getElementById('dvg_jeux').appendChild(k_jeux_a.clone2);
	document.getElementById('dvg_jeux').appendChild(k_jeux_a.clone1);
}


function init(){		//creation des instance pour le jeux et gestion des options
	
	k_jeux_a.hero=new moi();
	
	if(document.getElementById('laser_auto').checked){
		k_jeux_a.mode_laser='auto';
	}
	
	if(!isNaN(parseInt(document.getElementById('duree_partie').value))){
		k_jeux_a.duree_partie=parseInt(document.getElementById('duree_partie').value)*60;
	}
	
	for(var i = 0; i < 15; i++){		//15 est le nombre maximum de rayon lazer
		k_jeux_a.tbelement_tir[i]=new objet_tir();
	}
	
	if(!isNaN(parseInt(document.getElementById('nbr_soucoupe').value))){
		var nbr_soucoupe=parseInt(document.getElementById('nbr_soucoupe').value);		// le nombre de soucoupes au demarrage du jeux
	}
	else{
		var nbr_soucoupe=15;
	}
	
	for(var i = 0; i < nbr_soucoupe*500; i+=500){
		setTimeout(function(){
			
			var el=k_jeux_a.tb_mechant.push(new mechant());
			
			if(!isNaN(parseInt(document.getElementById('nbr_vitesse').value))){
				var vts=parseInt(document.getElementById('nbr_vitesse').value);
			}
			else{
				var vts=4;
			}
			
			if(document.getElementById('vt_aleatoire').checked){
				k_jeux_a.tb_mechant[el-1].px_vitesse=Math.ceil(Math.random()*vts);
			}
			else{
				k_jeux_a.tb_mechant[el-1].px_vitesse=vts;
			}
		},i);
		
	}

	typeof window.addEventListener == 'undefined' ? document.attachEvent("onmousemove",suivre) : addEventListener("mousemove",suivre, false);
	typeof window.addEventListener == 'undefined' ? document.attachEvent("onmousedown",clic_tir) : addEventListener("mousedown",clic_tir, false);
	typeof window.addEventListener == 'undefined' ? document.attachEvent("onmouseup",arret_laser) : addEventListener("mouseup",arret_laser, false);
	
	k_jeux_a.point=0;
	
	document.getElementById('point').firstChild.nodeValue=0;
	
	k_jeux_a.son_vie_gagne=k_jeux_a.creason('extensions/game/invasion/res/son/bonus');
	k_jeux_a.son_bonus=k_jeux_a.creason('extensions/game/invasion/res/son/bonus_b');
	
	if(localStorage.score1 && k_jeux_a.mode=='vie'){
		k_jeux_a.score=parseInt(localStorage.score1);
	}
	
}

</script>

	 <div id='dvg_jeux'>
	 
		<div id='dg_point'>
		 	<span id='point'>0</span>
			<br><span id='tmp'>00:00</span>
			<br><span id='nbr_vie'>3</span>
		</div>

		<div id='menu'>
			<div onclick='c_parti(this,"vie")' >mode vie</div>
			<div onclick='c_parti(this,"double")'>mode temp</div>
			<div onclick='c_parti(this,"ennemy")' >mode ennemy ++</div>
			<div onclick='c_parti(this,"vitesse")'>mode vitesses ++</div>
			<span>
			nombre de soucoupe<input type='texte' id='nbr_soucoupe' value=15 style='width:30px;'></input>

			vitesse aleatoire <input id='vt_aleatoire' type='checkbox' style='width:30px;'></input>

			laser auto<input type='checkbox' id='laser_auto' checked='checked' style='width:30px;'></input>

			vitesse au demarrage<input type='texte' id='nbr_vitesse' value=4 style='width:30px;'></input></span>

			duree partie<input type='texte' id='duree_partie' value=3 style='width:30px;'></input></span>

		</div>
	 </div>