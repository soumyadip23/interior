
    @foreach($childs as $child)
    <option value="{{ $child->id }}">{{ "----". $child->title}}</option>
        @if(count($child->childs))
                @include('manageChild',['childs' => $child->childs])
        @endif
    @endforeach
   