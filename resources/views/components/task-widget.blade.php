<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <p class="text-sm text-gray-500">{{ $title }}</p>
        <p class="text-2xl font-bold text-gray-800">{{ $stats['totalTask'] }}</p>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <p class="text-sm text-gray-500">{{ __('Pending') }}</p>
        <p class="text-2xl font-bold text-yellow-600">{{ $stats['totalPending'] }}</p>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <p class="text-sm text-gray-500">{{ __('In Progress') }}</p>
        <p class="text-2xl font-bold text-blue-600">{{ $stats['totalInProgress'] }}</p>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <p class="text-sm text-gray-500">{{ __('Completed') }}</p>
        <p class="text-2xl font-bold text-green-600">{{ $stats['totalCompleted'] }}</p>
    </div>
</div>
