{% extends 'base.html.twig' %}

{% block body %}

<h2 class="center-align">{{ username }}</h2>

<div class="row">
    {% if errors is defined and errors is iterable %}
    <div class="row">
        {% for error in errors %}
        <div class="col s12">
            <div class="card-panel red lighten-4">
                <span class="red-text text-darken-4">{{error}}</span>
            </div>
        </div>
        {% endfor %}
    </div>
    {% endif %}
</div>

<table class="highlight" style="margin-bottom: 10rem">
    <col style="width:3rem">
    <col style="width:3rem">
    <col style="width:auto">
    <col style="width:2rem">
    <col style="width:2rem">
    <thead>
        <tr>
            <th>#</th>
            <th>Count</th>
            <th>Name</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>

    <tbody>


        {% for item in items %}

        <tr>
            <td>{{ item.ItemId }}</td>
            <td>{{ item.Anzahl }}</td>
            <td><a href="/items/detail/{{ item.ItemId }}">{{ item.Name }}</a></td>
            <td>
                <a class="waves-effect waves-light btn" href="/items/edit/{{ item.ItemId }}">
                    <i class="material-icons center">edit</i>
                </a>
            </td>
            <td>
                <a class="waves-effect waves-light btn red" href="/items/remove/{{ item.ItemId }}">
                    <i class="material-icons center">delete</i>
                </a>
            </td>
        </tr>

        {% endfor %}

    </tbody>
</table>

<div class="row" style="position: fixed; bottom: 0; background: white; z-index: 999">
    <form action="/items/add" method="post">
        <div class="input-field col">
            <input id="anzahl" type="number" class="validate" name="anzahl">
            <label for="anzahl">Anzahl</label>
        </div>
        <div class="input-field col">
            <input id="name" type="text" class="validate" name="name" data-length="255">
            <label for="name">Name</label>
        </div>
        <div class="input-field col s2">
            <div class="right-align">
                <button class="btn waves-effect waves-light" type="submit" name="action">Submit
                    <i class="material-icons right">send</i>
                </button>
            </div>
        </div>
        <div class="input-field col s2">
            <div class="right-align">
                <a class="btn waves-effect waves-light" href="/logout">Logout
                    <i class="material-icons right">send</i>
                </a>
            </div>
        </div>
    </form>
</div>

{% endblock %}

{% block stylesheets %}

{% endblock %}

{% block javascripts %}

{% endblock %}
