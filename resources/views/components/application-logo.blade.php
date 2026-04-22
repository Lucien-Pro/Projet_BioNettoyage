<svg {{ $attributes->merge(['class' => 'w-16 h-16']) }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
    <!-- Goutte d'eau (contour bleu) -->
    <path d="M50,5 C75,5 92,25 92,50 C92,75 50,95 50,95 C50,95 8,75 8,50 C8,25 25,5 50,5 Z" 
          fill="none" stroke="#2ea3d6" stroke-width="8" stroke-linecap="round"/>
    
    <!-- Feuille verte -->
    <g transform="translate(30, 35) rotate(-10)">
        <path d="M5,45 C5,45 5,20 25,5 C45,20 45,45 45,45 C45,45 45,65 25,55 C5,65 5,45 5,45 Z" 
              fill="#4caf50"/>
        <!-- Nervure blanche -->
        <path d="M25,55 C25,55 25,35 25,5" 
              stroke="white" stroke-width="2" fill="none" stroke-linecap="round"/>
    </g>
</svg>
