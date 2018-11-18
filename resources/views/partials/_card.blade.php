<div class="box box-default">
    <div class="box-body">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <i class="fa fa-{{ isset($icon) ? $icon : 'user' }} text-{{ isset($color) ? $color : 'black' }}" style="font-size:75px"></i>
                    <span class="lead">{{ isset($title) ? $title : 'Title' }}</span>
                    <br>
                    <span>{{ isset($count) ? $count : 0 }}</span>
                </div>
            </div>
        </div>
    </div>
</div>