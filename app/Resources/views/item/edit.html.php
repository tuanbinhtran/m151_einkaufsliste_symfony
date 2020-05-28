{% extends 'base.html.twig' %}

{% block body %}

<h2 class="center-align">Edit</h2>

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

<div class="row">
    <form action="/comments/add/{{item.ItemId}}" method="post">
        <div class="input-field col s10">
            <input id="comment" type="text" class="validate" name="comment" data-length="255">
            <label for="comment">Comment</label>
        </div>
        <div class="input-field col s2">
            <div class="right-align">
                <button class="btn waves-effect waves-light" type="submit" name="action">Send
                    <i class="material-icons right">send</i>
                </button>
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
