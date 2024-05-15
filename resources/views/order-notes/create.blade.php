<x-layout>
    <div class="max-w-5xl mx-auto p-3 mt-22 md:w-8/12">
    <div class="card bg-white shadow-md rounded-lg">
            <div class="card-body p-6">
        <div class="mt-5">
            <h2 class="text-2xl font-semibold mb-3">Create Order Note</h2>
            <form action="{{ route('order-notes.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="branch_id" class="block text-sm font-medium text-gray-700">Branch</label>
                    <select id="branch_id" name="branch_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="note" class="block text-sm font-medium text-gray-700">Note</label>
                    <textarea id="note" name="note" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                </div>
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Create</button>
                </div>
            </form>
        </div>
</div>
</div>
    </div>
</x-layout>
