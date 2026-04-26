<?php

use App\Models\User;
?>

<div class="flex max-w-4xl mx-auto min-h-screen">

    <!-- サイドナビ -->
    <header class="w-56 shrink-0 sticky top-0 self-start h-screen border-r border-slate-100">
        <?php include COMPONENT_DIR . 'nav.php' ?>
    </header>

    <!-- メインコンテンツ -->
    <main class="flex-1 border-r border-slate-100 min-h-screen">
        <div class="p-5 border-b border-slate-100">
            <a href="<?= BASE_URL ?>user/?id=<?= $auth_user['id'] ?>" class="font-bold">&larr; <span class="ml-4">もどる</span></a>
        </div>
        <div class="w-full mt-3 p-5">
            <h2 class="text-2xl mb-3 font-bold text-center">プロフィールを編集</h2>

            <!-- ユーザ画像アップロード -->
            <div class="flex justify-center items-center">
                <div class="bg-white p-8 rounded-lg">
                    <form action="user/upload_profile_image.php" method="post" enctype="multipart/form-data" class="flex flex-col items-center">
                        <label for="image-input" class="cursor-pointer">
                            <img id="preview-image" src="<?= User::profileImage($auth_user['profile_image']) ?>" alt="Profile Picture" class="w-32 h-32 object-cover rounded-full mb-4">
                        </label>
                        <input onchange="selectProfileImage(this)" type="file" id="image-input" name="file" class="hidden" accept="image/*" required>
                        <label class="text-xs" for="image-input">画像を選択</label>
                        <button id="upload-button"
                            class="w-full text-sm my-2 py-1 px-3 bg-sky-500 hover:bg-sky-700 text-white rounded-lg hidden">
                            アップロード
                        </button>
                    </form>
                </div>
            </div>

            <!-- ユーザ編集フォーム -->
            <form id="profile-form">
                <div class="relative mb-4">
                    <input type="text" name="account_name"
                        id="account_name"
                        class="block px-2.5 pb-2.5 pt-6 mb-3 w-full rounded-lg text-sm text-gray-900 ring-1 ring-gray-300"
                        value="<?= $auth_user['account_name'] ?>"
                        placeholder=" " disabled>
                    <label for="email" class="absolute text-sm text-gray-400 transform -translate-y-4 scale-75 top-4 origin-[0] start-2.5">アカウント名</label>
                </div>
                <div class="relative mb-4">
                    <input type="text" name="account_name"
                        id="email"
                        class="block px-2.5 pb-2.5 pt-6 mb-3 w-full rounded-lg text-sm text-gray-900 ring-1 ring-gray-300"
                        value="<?= $auth_user['email'] ?>"
                        placeholder=" " disabled>
                    <label for="email" class="absolute text-sm text-gray-400 transform -translate-y-4 scale-75 top-4 origin-[0] start-2.5">Email</label>
                </div>

                <div class="relative mb-4">
                    <input type="text" name="display_name"
                        id="display_name"
                        class="block px-2.5 pb-2.5 pt-6 mb-3 w-full rounded-lg text-sm
                                    text-gray-900 ring-1 ring-gray-300 focus:outline-none focus:ring-1 focus:ring-blue-600 peer" value="<?= $auth_user['display_name'] ?>" placeholder=" " required>
                    <label for="name" class="absolute
                        text-sm text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 origin-[0] start-2.5
                        peer-focus:px-0
                        peer-focus:text-blue-600
                        peer-focus:dark:text-blue-500
                        peer-placeholder-shown:scale-100
                        peer-placeholder-shown:translate-y-0
                        peer-focus:scale-75
                        peer-focus:-translate-y-4">
                        ディスプレイ名
                    </label>
                </div>


                <div class="relative mb-4">
                    <textarea id="profile" oninput="autoResize(this)" name="profile"
                        class="block px-2.5 pb-2.5 pt-6 mb-3 w-full rounded-lg text-sm text-gray-900 ring-1 ring-gray-300
                                    focus:outline-none focus:ring-1 focus:ring-blue-600 peer"
                        placeholder=" "><?= @$auth_user['profile'] ?></textarea>
                    <label for="profile"
                        class="absolute text-sm text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 origin-[0] start-2.5
                                    peer-focus:px-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4">
                        自己紹介
                    </label>
                </div>

                <div id="form-message" class="hidden mb-3 text-sm text-center"></div>

                <div>
                    <button id="submit_button" class="w-full mb-2 py-2 px-4 bg-sky-500 hover:bg-sky-700 text-white rounded-lg">
                        保存
                    </button>
                </div>
            </form>
            <script>
                document.getElementById('profile-form').addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const btn = document.getElementById('submit_button');
                    const msg = document.getElementById('form-message');
                    btn.disabled = true;
                    msg.className = 'hidden mb-3 text-sm text-center';

                    try {
                        const uri = 'api/user/update.php';
                        const res = await fetch(uri, {
                            method: 'POST',
                            credentials: 'include',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                display_name: document.getElementById('display_name').value,
                                profile: document.getElementById('profile').value,
                            }),
                        });
                        const data = await res.json();
                        if (!res.ok) throw new Error(data.error || '更新に失敗しました');
                        msg.textContent = '保存しました';
                        msg.className = 'mb-3 text-sm text-center text-green-600';
                    } catch (err) {
                        msg.textContent = err.message;
                        msg.className = 'mb-3 text-sm text-center text-red-500';
                    } finally {
                        btn.disabled = false;
                    }
                });
            </script>
        </div>
    </main>

</div>
