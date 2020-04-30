{% extends 'base.html.twig' %}

{% block body %}

<h1 class="center-align" >Einkaufsliste</h1>

<table class="highlight">
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
    <td>{{ item.Name }}</td>
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

<div class="row" style="position: absolute; bottom: 0; width:100%;">
    <form class="col s12" action="/items/add" method="post">
        <div class="row">
            <div class="input-field col s4">
                <input id="anzahl" type="number" class="validate" name="anzahl">
                <label for="anzahl">Anzahl</label>
            </div>
            <div class="input-field col s6">
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
        </div>
    </form>
</div>

{% endblock %}

{% block stylesheets %}

{% endblock %}

{% block javascripts %}

{% endblock %}
