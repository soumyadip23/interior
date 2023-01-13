<?php  

if(isset($targetitem->category_id)) {  $item_to_match = $targetitem->category_id; } else{ $item_to_match = ''; }

if(isset($targetCategory->parent_id)) {  $item_match = $targetCategory->parent_id; } else{ $item_match = ''; }

?>  
    @foreach($childs as $child)
    <option value="{{ $child->id }}" 
         {{ $child->id == $item_to_match ? 'selected' : '' }}{{ $child->id == $item_match ? 'selected' : '' }}>{{ "--". $child->title}}</option>
        @if(count($child->childs))
                @include('manageChildTwo',['childs' => $child->childs])
        @endif
    @endforeach
   