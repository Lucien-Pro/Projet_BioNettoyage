<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-2 bg-gradient-to-r from-brand-primary to-brand-secondary border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 active:translate-y-0']) }}>
    {{ $slot }}
</button>
