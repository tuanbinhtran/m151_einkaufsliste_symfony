{% extends 'base.html.twig' %}

{% block body %}

<h2 class="center-align">Detail von {{ item.Name }}</h2>

<div class="row">
    <div class="row">
        <div class="col s12">
            <label for="name">Name</label>
            <p id="name" name="name">{{item.Name}}</p>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <label for="anzahl">Anzahl</label>
            <p id="anzahl" name="anzahl">{{item.Anzahl}}</p>
        </div>
    </div>
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

{% if comments is defined and comments is iterable  and comments[0] is defined%}
<ul class="collection">
    {% for comment in comments %}
    <li class="collection-item">
        <span class="title">
            <div class="chip teal lighten-2">
                <span class="blue-text text-lighten-5">
                    {{comment.Username}}
                </span>
            </div>
            <div class="chip">
                {{comment.Timestamp}}
            </div>
            {% if comment.UserId == userId %}
            <a>
                <div class="secondary-content">
                    <i class="material-icons">close</i>
                </div>
            </a>
            {% endif %}
        </span>

        <p>{{comment.Comment}}</p>

    </li>
    {% endfor %}
</ul>
{% endif %}

{% endblock %}

{% block stylesheets %}

{% endblock %}

{% block javascripts %}

function onSubmit() {
console.log('test');
}

{% endblock %}
