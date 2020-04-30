{% extends 'base.html.twig' %}

{% block body %}

<h1 class="center-align">Einkaufsliste - Edit</h1>

<div class="row">
    <form class="col s12" action="/items/edit/{{item.ItemId}}" method="post" onsubmit="onSubmit()">
        <div class="row">
            <div class="input-field col s12">
                <input id="anzahl" type="number" class="validate" name="anzahl" value="{{item.Anzahl}}">
                <label for="anzahl">Anzahl</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input id="name" type="text" class="validate" name="name" value="{{item.Name}}" data-length="255">
                <label for="name">Name</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <div class="right-align">
                    <button class="btn waves-effect waves-light" type="submit" name="action">Submit
                        <i class="material-icons right">send</i>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

{% endblock %}

{% block stylesheets %}

{% endblock %}

{% block javascripts %}

function onSubmit() {
    console.log('test');
}

{% endblock %}
