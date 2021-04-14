<div class="star-rating">
    @for($i = 1; $i <= 5; $i++)
        @if( $rating >= $i )
            <span class="complete"></span>
        @elseif( $rating < $i && $rating+1 > $i )
            @php 
                $x = $rating - floor($rating);
            @endphp
            
            @if ( $x < 0.3 ) 
                <span class="empty"></span>
            @elseif ( $x > 0.7 )
                <span class="complete"></span>
            @else
                <span class="half"></span>
            @endif
        @else
            <span class="empty"></span>
        @endif
    @endfor
</div>