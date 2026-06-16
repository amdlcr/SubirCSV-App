@props(['flechas'])

@if($flechas === 'primera')
    <i class="fa-solid fa-angles-left"></i>
@elseif($flechas === 'izquierda')
    <i class="fa-solid fa-angle-left"></i>
@elseif($flechas === 'derecha')
    <i class="fa-solid fa-angle-right"></i>
@elseif($flechas === 'ultima')
    <i class="fa-solid fa-angles-right"></i>
@endif
