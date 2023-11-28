  <!-- Card Body -->
  <div {{ $attributes->merge(['class' => 'p-5 grow']) }}>
      <!-- Placeholder -->
      <div
          {{ $attributes->merge(['class' => ' rounded-xl text-black dark:text-white dark:bg-gray-800 dark:border-gray-700']) }}>
          {{ $slot }}
      </div>
  </div>
  <!-- Card Body -->
