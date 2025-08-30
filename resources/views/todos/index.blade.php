@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Add Todo Form -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-lg p-6 animate-slide-up">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">
                <i class="fas fa-plus-circle text-indigo-600 mr-2"></i>
                Add New Todo
            </h2>
            
            <form action="{{ route('todos.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <input type="text" name="title" placeholder="Todo title..." 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                           required>
                </div>
                
                <div>
                    <textarea name="description" placeholder="Description (optional)..." 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all h-24 resize-none"></textarea>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <select name="priority" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                            <option value="low">🟢 Low</option>
                            <option value="medium" selected>🟡 Medium</option>
                            <option value="high">🔴 High</option>
                        </select>
                    </div>
                    
                    <div>
                        <input type="date" name="due_date" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                    </div>
                </div>
                
                <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                    <i class="fas fa-plus mr-2"></i>Add Todo
                </button>
            </form>
        </div>
    </div>

    <!-- Todos List -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-lg p-6 animate-slide-up">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-800">
                    <i class="fas fa-list text-indigo-600 mr-2"></i>
                    Your Todos ({{ $todos->count() }})
                </h2>
                
                <div class="flex space-x-2 text-sm">
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full">
                        {{ $todos->where('completed', true)->count() }} Completed
                    </span>
                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full">
                        {{ $todos->where('completed', false)->count() }} Pending
                    </span>
                </div>
            </div>

            @if($todos->isEmpty())
                <div class="text-center py-12">
                    <i class="fas fa-clipboard-list text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg">No todos yet. Create your first one!</p>
                </div>
            @else
                <div class="space-y-4 max-h-96 overflow-y-auto">
                    @foreach($todos as $todo)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow {{ $todo->completed ? 'bg-gray-50' : 'bg-white' }}">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <form action="{{ route('todos.toggle', $todo) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-2xl hover:scale-110 transition-transform">
                                                @if($todo->completed)
                                                    <i class="fas fa-check-circle text-green-500"></i>
                                                @else
                                                    <i class="far fa-circle text-gray-400"></i>
                                                @endif
                                            </button>
                                        </form>
                                        
                                        <h3 class="font-medium text-gray-800 {{ $todo->completed ? 'line-through text-gray-500' : '' }}">
                                            {{ $todo->title }}
                                        </h3>
                                        
                                        <span class="priority-badge priority-{{ $todo->priority }}">
                                            @if($todo->priority === 'high') 🔴
                                            @elseif($todo->priority === 'medium') 🟡
                                            @else 🟢
                                            @endif
                                            {{ ucfirst($todo->priority) }}
                                        </span>
                                    </div>
                                    
                                    @if($todo->description)
                                        <p class="text-gray-600 text-sm mb-2 {{ $todo->completed ? 'line-through' : '' }}">
                                            {{ $todo->description }}
                                        </p>
                                    @endif
                                    
                                    <div class="flex items-center space-x-4 text-xs text-gray-500">
                                        <span>
                                            <i class="fas fa-calendar mr-1"></i>
                                            Created {{ $todo->created_at->diffForHumans() }}
                                        </span>
                                        
                                        @if($todo->due_date)
                                            <span class="{{ $todo->due_date->isPast() && !$todo->completed ? 'text-red-500' : '' }}">
                                                <i class="fas fa-clock mr-1"></i>
                                                Due {{ $todo->due_date->format('M j, Y') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex space-x-2 ml-4">
                                    <button onclick="editTodo({{ $todo->id }}, '{{ $todo->title }}', '{{ $todo->description }}', '{{ $todo->priority }}', '{{ $todo->due_date ? $todo->due_date->format('Y-m-d') : '' }}')" 
                                            class="text-blue-600 hover:text-blue-800 transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <form action="{{ route('todos.destroy', $todo) }}" method="POST" class="inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this todo?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4">
        <h3 class="text-lg font-semibold mb-4">Edit Todo</h3>
        
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <input type="text" id="editTitle" name="title" placeholder="Todo title..." 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" required>
                
                <textarea id="editDescription" name="description" placeholder="Description (optional)..." 
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all h-24 resize-none"></textarea>
                
                <div class="grid grid-cols-2 gap-4">
                    <select id="editPriority" name="priority" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        <option value="low">🟢 Low</option>
                        <option value="medium">🟡 Medium</option>
                        <option value="high">🔴 High</option>
                    </select>
                    
                    <input type="date" id="editDueDate" name="due_date" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                </div>
            </div>
            
            <div class="flex space-x-3 mt-6">
                <button type="submit" class="flex-1 bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition-colors">
                    Update
                </button>
                <button type="button" onclick="closeEditModal()" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .priority-badge {
        @apply px-2 py-1 rounded-full text-xs font-medium;
    }
    .priority-high {
        @apply bg-red-100 text-red-800;
    }
    .priority-medium {
        @apply bg-yellow-100 text-yellow-800;
    }
    .priority-low {
        @apply bg-green-100 text-green-800;
    }
</style>

<script>
    function editTodo(id, title, description, priority, dueDate) {
        document.getElementById('editTitle').value = title;
        document.getElementById('editDescription').value = description;
        document.getElementById('editPriority').value = priority;
        document.getElementById('editDueDate').value = dueDate;
        document.getElementById('editForm').action = `/todos/${id}`;
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editModal').classList.remove('flex');
    }

    // Close modal when clicking outside
    document.getElementById('editModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditModal();
        }
    });
</script>
@endsection
