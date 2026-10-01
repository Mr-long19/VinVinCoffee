<?php
session_start();

// Include db.php safely from current api directory or fallback to parent
if (file_exists(__DIR__ . '/db.php')) {
    require_once __DIR__ . '/db.php';
} elseif (file_exists(__DIR__ . '/../db.php')) {
    require_once __DIR__ . '/../db.php';
} else {
    require_once 'db.php';
}

// Handle Language Switch (KH / EN)
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'] === 'kh' ? 'kh' : 'en';
}
$lang = $_SESSION['lang'] ?? 'en';

// Translations Dictionary
$t = [
    'en' => [
        'title' => 'Roast & Craft - Admin Dashboard',
        'dashboard' => 'Dashboard Management',
        'logout' => 'Logout',
        'login_title' => 'Admin & Staff Login',
        'username' => 'Username',
        'email' => 'Email Address',
        'password' => 'Password',
        'login_btn' => 'Sign In',
        'reset_link' => 'Forgot Password? Reset Here',
        'reset_title' => 'Reset Password Request',
        'reset_pass_title' => 'Enter New Password',
        'new_password' => 'New Password',
        'request_reset_btn' => 'Send Reset Link',
        'reset_btn' => 'Update Password',
        'back_to_login' => 'Back to Login',
        'tab_menu' => 'Menu Items',
        'tab_ai' => 'AI Knowledge Base',
        'tab_users' => 'Users & Staff',
        'tab_settings' => 'Settings',
        'add_item' => 'Add Menu Item',
        'add_user' => 'Create New User / Staff',
        'add_ai_doc' => 'Add Knowledge Doc',
        'light' => 'Light Mode',
        'dark' => 'Dark Mode',
        'unauthorized' => 'Access Denied: You do not have permission to view this section.',
        'settings_header' => 'System & Store Configuration',
        'settings_sub' => 'Manage your coffee shop profile, operational preferences, dual-currency exchange rates, and AI assistant behavior.',
        'sec_general' => 'Store Profile & Identity',
        'sec_hours' => 'Operating Hours & Status',
        'sec_currency' => 'Currency & Pricing',
        'sec_ai' => 'AI Assistant Configuration',
        'sec_security' => 'Security & Access Control',
        'store_name' => 'Store Name',
        'store_email' => 'Contact Email',
        'store_phone' => 'Phone Number',
        'store_address' => 'Physical Address',
        'currency_rate' => 'Exchange Rate (1 USD to KHR)',
        'ai_prompt' => 'Custom AI System Prompt & Rules',
        'save_settings' => 'Save Configuration Changes',
        'settings_success' => 'Configuration updated successfully!'
    ],
    'kh' => [
        'title' => 'រ៉ូស & ក្ដាហ្វ - ទំព័រគ្រប់គ្រង',
        'dashboard' => 'ផ្ទាំងគ្រប់គ្រង',
        'logout' => 'ចាកចេញ',
        'login_title' => 'ចូលគណនីរដ្ឋបាល និងបុគ្គលិក',
        'username' => 'ឈ្មោះអ្នកប្រើប្រាស់',
        'email' => 'អ៊ីមែល',
        'password' => 'ពាក្យសម្ងាត់',
        'login_btn' => 'ចូលគណនី',
        'reset_link' => 'ភ្លេចពាក្យសម្ងាត់? កំណត់ឡើងវិញ',
        'reset_title' => 'ស្នើសុំកំណត់ពាក្យសម្ងាត់ឡើងវិញ',
        'reset_pass_title' => 'បញ្ចូលពាក្យសម្ងាត់ថ្មី',
        'new_password' => 'ពាក្យសម្ងាត់ថ្មី',
        'request_reset_btn' => 'ផ្ញើតំណភ្ជាប់កំណត់ឡើងវិញ',
        'reset_btn' => 'ប្តូរពាក្យសម្ងាត់',
        'back_to_login' => 'ត្រឡប់ទៅការចូល',
        'tab_menu' => 'មុខម្ហូប',
        'tab_ai' => 'មូលដ្ឋានទិន្នន័យ AI',
        'tab_users' => 'អ្នកប្រើប្រាស់ និងបុគ្គលិក',
        'tab_settings' => 'ការកំណត់ប្រព័ន្ធ',
        'add_item' => 'បន្ថែមមុខម្ហូបថ្មី',
        'add_user' => 'បង្កើតអ្នកប្រើប្រាស់ / បុគ្គលិកថ្មី',
        'add_ai_doc' => 'បន្ថែមឯកសារចំណេះដឹង',
        'light' => 'ពណ៌ភ្លឺ',
        'dark' => 'ពណ៌ងងឹត',
        'unauthorized' => 'ការចូលត្រូវបានបដិសេធ៖ អ្នកមិនមានសិទ្ធិមើលផ្នែកនេះទេ។',
        'settings_header' => 'ការកំណត់ប្រព័ន្ធ និងហាងកាហ្វេ',
        'settings_sub' => 'គ្រប់គ្រងព័ត៌មានហាង ម៉ោងបើក-បិទ អត្រាប្តូរប្រាក់ USD/KHR និងការកំណត់ជំនួយការ AI ។',
        'sec_general' => 'ព័ត៌មានលម្អិតហាង',
        'sec_hours' => 'ម៉ោងធ្វើការ និងស្ថានភាព',
        'sec_currency' => 'រូបិយប័ណ្ណ និងតម្លៃ',
        'sec_ai' => 'ការកំណត់ជំនួយការ AI',
        'sec_security' => 'សុវត្ថិភាព និងការគ្រប់គ្រងសិទ្ធិ',
        'store_name' => 'ឈ្មោះហាង',
        'store_email' => 'អ៊ីមែលទំនាក់ទំនង',
        'store_phone' => 'លេខទូរស័ព្ទ',
        'store_address' => 'អាសយដ្ឋានហាង',
        'currency_rate' => 'អត្រាប្តូរប្រាក់ (១ ដុល្លារ ជា រៀល)',
        'ai_prompt' => 'បទបញ្ជាប្រព័ន្ធ AI (System Prompt)',
        'save_settings' => 'រក្សាទុកការផ្លាស់ប្តូរ',
        'settings_success' => 'ការកំណត់ត្រូវបានរក្សាទុកដោយជោគជ័យ!'
    ]
];
$tr = $t[$lang];

// Theme Mode Toggle
if (isset($_POST['toggle_theme'])) {
    $_SESSION['theme'] = (($_SESSION['theme'] ?? 'light') === 'dark') ? 'light' : 'dark';
    header("Location: admin.php?tab=" . ($_GET['tab'] ?? 'menu'));
    exit;
}
$current_theme = $_SESSION['theme'] ?? 'light';

// View Mode ('login', 'request_reset', 'process_reset')
$auth_view = $_GET['view'] ?? 'login';
if (isset($_GET['reset_token'])) {
    $auth_view = 'process_reset';
}

$login_error = isset($db_connection_error) ? "Database Error: " . $db_connection_error : '';
$reset_msg = '';

// Login Action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $user = trim($_POST['username']);
    $pass = $_POST['password'];

    if (isset($pdo)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM public.users WHERE username = ? OR email = ?");
            $stmt->execute([$user, $user]);
            $account = $stmt->fetch();

            if ($account) {
                $stored_pass = $account['password_hash'] ?? $account['password'] ?? '';
                if ($pass === $stored_pass || password_verify($pass, $stored_pass)) {
                    $_SESSION['admin_logged'] = true;
                    $_SESSION['username'] = $account['username'];
                    $_SESSION['role'] = $account['role'] ?? 'admin';
                    header("Location: admin.php");
                    exit;
                }
            }
            $login_error = "Invalid username or password!";
        } catch (Exception $e) {
            $login_error = "Database Error: " . $e->getMessage();
        }
    }
}

// Request Password Reset
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'forgot_password') {
    $email = trim($_POST['email']);
    
    if (isset($pdo)) {
        try {
            $stmt = $pdo->prepare("SELECT id FROM public.users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            
            if ($user) {
                $token = bin2hex(random_bytes(32));
                $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
                
                $updateStmt = $pdo->prepare("UPDATE public.users SET reset_token = ?, reset_token_expires = ? WHERE id = ?");
                $updateStmt->execute([$token, $expires, $user['id']]);
                
                $reset_link = "admin.php?reset_token=" . $token;
                $reset_msg = "Reset token generated! <a href='{$reset_link}' class='underline font-bold text-caramel'>Click here to set new password</a>";
            } else {
                $login_error = "Email address not found!";
            }
        } catch (Exception $e) {
            $login_error = "Error: " . $e->getMessage();
        }
    }
}

// Process Password Reset
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'reset_password') {
    $token = $_POST['reset_token'];
    $new_password = $_POST['new_password'];
    
    if (isset($pdo)) {
        try {
            $stmt = $pdo->prepare("SELECT id FROM public.users WHERE reset_token = ? AND reset_token_expires > NOW()");
            $stmt->execute([$token]);
            $user = $stmt->fetch();
            
            if ($user) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                
                $updateStmt = $pdo->prepare("UPDATE public.users SET password_hash = ?, reset_token = NULL, reset_token_expires = NULL WHERE id = ?");
                $updateStmt->execute([$hashed_password, $user['id']]);
                
                $reset_msg = "Password reset successful! You can now log in.";
                $auth_view = 'login';
            } else {
                $login_error = "Invalid or expired reset token!";
            }
        } catch (Exception $e) {
            $login_error = "Reset error: " . $e->getMessage();
        }
    }
}

// Handle Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" class="<?= $current_theme === 'dark' ? 'dark bg-gray-900 text-white' : 'bg-cream text-espresso' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $tr['title'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Kantumruy+Pro:wght@400;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', '"Kantumruy Pro"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif']
                    },
                    colors: {
                        espresso: '#1b1411',
                        caramel: '#8c5a3c',
                        latte: '#cda880',
                        foam: '#f7f4ef',
                        cream: '#faf8f5'
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen flex flex-col font-sans transition-colors duration-300">

    <?php if (!isset($_SESSION['admin_logged'])): ?>
    <div class="flex-1 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-xl max-w-md w-full border border-caramel/20">
            <div class="text-center mb-6">
                <div class="w-12 h-12 rounded-full bg-caramel/20 text-caramel flex items-center justify-center mx-auto mb-3">
                    <i class="fa-solid fa-lock text-xl"></i>
                </div>
                <h2 class="font-serif text-2xl font-bold">
                    <?php 
                    if ($auth_view === 'request_reset') echo $tr['reset_title'];
                    elseif ($auth_view === 'process_reset') echo $tr['reset_pass_title'];
                    else echo $tr['login_title'];
                    ?>
                </h2>
                <div class="flex justify-center gap-4 mt-2 text-xs">
                    <a href="admin.php?lang=en&view=<?= $auth_view ?>" class="underline font-semibold <?= $lang==='en'?'text-caramel':'' ?>">English</a>
                    <a href="admin.php?lang=kh&view=<?= $auth_view ?>" class="underline font-semibold <?= $lang==='kh'?'text-caramel':'' ?>">ភាសាខ្មែរ</a>
                </div>
            </div>

            <?php if ($login_error): ?>
                <div class="mb-4 p-3 bg-red-100 text-red-700 text-xs rounded-xl font-medium break-words"><?= $login_error ?></div>
            <?php endif; ?>
            <?php if ($reset_msg): ?>
                <div class="mb-4 p-3 bg-emerald-100 text-emerald-800 text-xs rounded-xl font-medium"><?= $reset_msg ?></div>
            <?php endif; ?>

            <?php if ($auth_view === 'login'): ?>
            <form method="POST" class="space-y-4">
                <input type="hidden" name="action" value="login">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider mb-1"><?= $tr['username'] ?></label>
                    <input type="text" name="username" required class="w-full px-4 py-2.5 rounded-xl bg-gray-50 dark:bg-gray-700 border border-caramel/20 text-sm focus:outline-none focus:border-caramel">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider mb-1"><?= $tr['password'] ?></label>
                    <input type="password" name="password" required class="w-full px-4 py-2.5 rounded-xl bg-gray-50 dark:bg-gray-700 border border-caramel/20 text-sm focus:outline-none focus:border-caramel">
                </div>
                <button type="submit" class="w-full py-3.5 rounded-xl bg-caramel hover:bg-opacity-90 text-white font-bold text-sm transition-colors shadow-md">
                    <?= $tr['login_btn'] ?>
                </button>
                <div class="text-center pt-2">
                    <a href="admin.php?view=request_reset&lang=<?= $lang ?>" class="text-xs text-caramel hover:underline font-semibold"><?= $tr['reset_link'] ?></a>
                </div>
            </form>

            <?php elseif ($auth_view === 'request_reset'): ?>
            <form method="POST" class="space-y-4">
                <input type="hidden" name="action" value="forgot_password">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider mb-1"><?= $tr['email'] ?></label>
                    <input type="email" name="email" required placeholder="admin@example.com" class="w-full px-4 py-2.5 rounded-xl bg-gray-50 dark:bg-gray-700 border border-caramel/20 text-sm focus:outline-none focus:border-caramel">
                </div>
                <button type="submit" class="w-full py-3.5 rounded-xl bg-caramel hover:bg-opacity-90 text-white font-bold text-sm transition-colors shadow-md">
                    <?= $tr['request_reset_btn'] ?>
                </button>
                <div class="text-center pt-2">
                    <a href="admin.php?view=login&lang=<?= $lang ?>" class="text-xs text-caramel hover:underline font-semibold"><?= $tr['back_to_login'] ?></a>
                </div>
            </form>

            <?php elseif ($auth_view === 'process_reset'): ?>
            <form method="POST" class="space-y-4">
                <input type="hidden" name="action" value="reset_password">
                <input type="hidden" name="reset_token" value="<?= htmlspecialchars($_GET['reset_token'] ?? '') ?>">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider mb-1"><?= $tr['new_password'] ?></label>
                    <input type="password" name="new_password" required class="w-full px-4 py-2.5 rounded-xl bg-gray-50 dark:bg-gray-700 border border-caramel/20 text-sm focus:outline-none focus:border-caramel">
                </div>
                <button type="submit" class="w-full py-3.5 rounded-xl bg-caramel hover:bg-opacity-90 text-white font-bold text-sm transition-colors shadow-md">
                    <?= $tr['reset_btn'] ?>
                </button>
                <div class="text-center pt-2">
                    <a href="admin.php?view=login&lang=<?= $lang ?>" class="text-xs text-caramel hover:underline font-semibold"><?= $tr['back_to_login'] ?></a>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
    <?php else: ?>
    <div class="p-8">
        <h1 class="text-2xl font-bold">Welcome, <?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></h1>
        <a href="admin.php?logout=1" class="text-red-600 font-bold underline mt-4 inline-block">Logout</a>
    </div>
    <?php endif; ?>

</body>
</html>
