<?php
require_once 'config.php';

// Ambil data sekolah dari database
$query = "SELECT * FROM profil_sekolah LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
} else {
    // Jika tidak ada data, isi dengan nilai default
    $data = [
        'name' => '',
        'shortName' => '',
        'address' => '',
        'email' => '',
        'instagram' => '',
        'whatsapp' => '',
        'motto' => ''
    ];
}
?>

<main class="container mx-auto p-4 max-w-7xl">
        <!-- School Info Section -->
        <section id="school-info" class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b">School Information</h2>
            <form class="ajax-form" data-section="school">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">School Name</label>
                        <input type="text" name="name" value="<?php echo htmlspecialchars($data['school']['name']); ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Short Name</label>
                        <input type="text" name="shortName" value="<?php echo htmlspecialchars($data['school']['shortName']); ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Address</label>
                    <textarea name="address" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 h-24"><?php echo htmlspecialchars($data['school']['address']); ?></textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($data['school']['email']); ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Instagram URL</label>
                        <input type="url" name="instagram" value="<?php echo htmlspecialchars($data['school']['instagram']); ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">WhatsApp URL</label>
                        <input type="url" name="whatsapp" value="<?php echo htmlspecialchars($data['school']['whatsapp']); ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Motto</label>
                    <textarea name="motto" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 h-24"><?php echo htmlspecialchars($data['school']['motto']); ?></textarea>
                </div>
                
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-md transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Save Changes
                </button>
            </form>
        </section>