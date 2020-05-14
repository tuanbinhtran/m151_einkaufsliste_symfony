{% extends 'base.html.twig' %}

{% block body %}

<h2 class="center-align">Login</h2>

<div class="row">
    <form class="col s12" action="/login" method="post" onsubmit="onSubmit()">
        <div class="row">
            <div class="input-field col s12">
                <input id="username" type="text" class="validate" name="username">
                <label for="username">Username</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input id="password" type="password" class="validate" name="password" data-length="255">
                <label for="password">Password</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <div class="right-align">
                    <button class="btn waves-effect waves-light" type="submit" name="action">Login
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
