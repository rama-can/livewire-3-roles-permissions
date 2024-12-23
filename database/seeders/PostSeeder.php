<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ambil user yang bernama Rama Can
        $users = User::where('email', 'admin@gmail.com')->pluck('id');
        $categories = Category::pluck('id'); // Ambil semua category_id

        $content = [
            'en' => '## Next.js GitHub Markdown Blog

A modern, feature-rich blogging platform that uses GitHub as a CMS. Transform your Markdown files into a beautiful, responsive blog with minimal setup. Perfect for developers who want to keep their content in GitHub and integrate a blog into their Next.js applications.

## ✨ Features

### Content Management
- 📝 Write posts in Markdown with full GitHub Flavored Markdown support
- 🎨 Frontmatter for rich metadata and customization
- 📑 Automatic category and tag organization
- 📊 Reading time estimation

### Design & UI
- 🎯 Responsive, mobile-first design
- 🖼️ Optimized image loading with blur placeholders
- 🌙 Smooth animations and transitions
- 📱 Progressive Web App (PWA) ready
- 🎨 Customizable design system via Tailwind CSS

### Performance & SEO
- ⚡ Static Site Generation (SSG) for optimal performance
- 🔍 SEO optimized with meta tags and structured data
- 📱 Mobile performance optimized
- 🖼️ Automatic image optimization
- 🗺️ Automatic sitemap generation

### Social & Sharing
- 🔗 Social media sharing buttons
- 👥 Author profiles and bios
- 📊 Reading progress indicator
- ⬆️ Scroll to top button
- 💬 Related posts suggestions

## 🚀 Getting Started

### Prerequisites
- Node.js 18+ and npm/yarn/bun
- A GitHub account
- A GitHub repository for your blog posts

### Basic Setup

1. Clone this repository:
```bash
git clone https://github.com/yourusername/nextjs-github-markdown-blog.git
cd nextjs-github-markdown-blog
```

2. Install dependencies:
```bash
npm install   # or yarn install or bun install
```

3. Create a GitHub repository for your blog posts and create a personal access token:
   - Go to GitHub Settings -> Developer Settings -> Personal Access Tokens
   - Generate a new token with `repo` scope
   - Copy the token for the next step

4. Create a `.env.local` file:
```bash
# Required
GITHUB_REPO=username/blog-posts-repo
GITHUB_TOKEN=your_github_token_here

# Optional but recommended
NEXT_PUBLIC_SITE_URL=https://your-blog-domain.com
NEXT_PUBLIC_SITE_NAME=Your Blog Name
NEXT_PUBLIC_SITE_DESCRIPTION=Your blog description
NEXT_PUBLIC_TWITTER_HANDLE=@yourusername
```

5. Run the development server:
```bash
npm run dev   # or yarn dev or bun dev
```

### Integrating with Existing Next.js App

1. Copy the required directories to your project:
```
src/
├── components/    # Blog components
├── lib/          # Blog utilities
└── app/
    └── blog/     # Blog pages
```

2. Add required dependencies to your `package.json`:
```json
{
  "dependencies": {
    "gray-matter": "^4.0.3",
    "reading-time": "^1.5.0",
    "rehype": "^13.0.2",
    "rehype-highlight": "^7.0.1",
    "rehype-prism-plus": "2.0.0",
    "rehype-raw": "^7.0.0",
    "rehype-sanitize": "6.0.0",
    "rehype-stringify": "10.0.1",
    "remark": "15.0.1",
    "remark-gfm": "4.0.0",
    "remark-html": "^16.0.1",
    "remark-parse": "11.0.0",
    "remark-rehype": "11.1.1"
  }
}',
            'id' => '## Next.js GitHub Markdown Blog

Platform blog modern dan kaya fitur yang menggunakan GitHub sebagai CMS. Ubah berkas-berkas Markdown Anda menjadi blog yang indah dan responsif dengan pengaturan minimal. Sempurna untuk pengembang yang ingin menyimpan konten mereka di GitHub dan mengintegrasikan blog ke dalam aplikasi Next.js mereka.

## ✨ Fitur

### Manajemen Konten
- 📝 Tulis postingan di Markdown dengan dukungan penuh GitHub Flavored Markdown
- 🎨 Frontmatter untuk metadata yang kaya dan kustomisasi
- 📑 Pengaturan kategori dan tag secara otomatis
- 📊 Estimasi waktu membaca

### Desain & UI
- 🎯 Desain yang responsif dan mengutamakan seluler
- 🖼️ Pemuatan gambar yang dioptimalkan dengan penampung gambar blur
- 🌙 Animasi dan transisi yang halus
- 📱 Siap untuk Aplikasi Web Progresif (PWA)
- 🎨 Sistem desain yang dapat disesuaikan melalui Tailwind CSS

### Performa & SEO
- ⚡ Pembuatan Situs Statis (SSG) untuk performa optimal
- 🔍 SEO dioptimalkan dengan meta tag dan data terstruktur
- 📱 Performa seluler dioptimalkan
- 🖼️ Pengoptimalan gambar otomatis
- 🗺️ Pembuatan peta situs otomatis

### Sosial & Berbagi
- 🔗 Tombol berbagi media sosial
- 👥 Profil dan biodata penulis
- 📊 Indikator kemajuan membaca
- ⬆️ Tombol gulir ke atas
- 💬 Saran untuk postingan terkait

## 🚀 Memulai

### Prasyarat
- Node.js 18+ dan npm/yarn/bun
- Akun GitHub
- Repositori GitHub untuk postingan blog Anda

### Penyiapan Dasar

1. Kloning repositori ini:
```bash
git clone https://github.com/yourusername/nextjs-github-markdown-blog.git
cd nextjs-github-markdown-blog
```

2. Menginstal dependensi:
```bash
npm install # atau yarn install atau bun install
```

3. Buat repositori GitHub untuk posting blog Anda dan buat token akses pribadi:
   - Buka Pengaturan GitHub -> Pengaturan Pengembang -> Token Akses Pribadi
   - Buat token baru dengan cakupan `repo`
   - Salin token untuk langkah selanjutnya

4. Buat file `.env.local`:
```bash
# Wajib diisi
GITHUB_REPO = nama pengguna/blog-posts-repo
GITHUB_TOKEN = github_token_Anda di sini

# Opsional tetapi disarankan
NEXT_PUBLIC_SITE_URL = https://your-blog-domain.com
NEXT_PUBLIC_SITE_NAME = Nama Blog Anda
NEXT_PUBLIC_SITE_DESCRIPTION = Deskripsi blog Anda
NEXT_PUBLIC_TWITTER_HANDLE = @namapengguna Anda
```

5. Jalankan server pengembangan:
```bash
npm jalankan dev # atau yarn dev atau bun dev
```

### Mengintegrasikan dengan Aplikasi Next.js yang Sudah Ada

1. Salin direktori yang diperlukan ke dalam proyek Anda:
```
src/
├── components/ # Komponen blog
├── lib/ # Utilitas blog
└── app/
    └── blog/ # Halaman blog
```

2. Tambahkan dependensi yang diperlukan ke `package.json` Anda:
```json
{
  “dependencies": {
    “gray-matter": “^4.0.3”,
    “waktu-baca": “^1.5.0”,
    “rehype": “^13.0.2”,
    “rehype-highlight": “^7.0.1”,
    “rehype-prism-plus": “2.0.0”,
    “rehype-raw": “^7.0.0”,
    “rehype-sanitize": “6.0.0”,
    “rehype-stringify": “10.0.1”,
    “remark": “15.0.1”,
    “remark-gfm": “4.0.0”,
    “komentar-html": “^16.0.1”,
    “comment-parse": “11.0.0”,
    “comment-rehype": “11.1.1”
  }
}',
        ];
        $desc = [
            'en' => 'Next. js is more feature-rich and opinionated than React. It is especially well-suited for websites focused on search engine optimization (SEO) or pre-rendering.',
            'id' => 'Next.js lebih kaya akan fitur dan opini daripada React. Ini sangat cocok untuk situs web yang berfokus pada pengoptimalan mesin pencari (SEO) atau pra-rendering.',
        ];

        $posts = [
            [
                'en' => [
                    'title' => 'First Post Title',
                    'slug' => 'first-post-title',
                    'description' => $desc['en'],
                    'content' => $content['en'],
                ],
                'id' => [
                    'title' => 'Judul Post Pertama',
                    'slug' => 'judul-post-pertama',
                    'description' => $desc['id'],
                    'content' => $content['id'],
                ],
            ],
            [
                'en' => [
                    'title' => 'Second Post Title',
                    'slug' => 'second-post-title',
                    'description' => $desc['en'],
                    'content' => $content['en'],
                ],
                'id' => [
                    'title' => 'Judul Post Kedua',
                    'slug' => 'judul-post-kedua',
                    'description' => $desc['id'],
                    'content' => $content['id'],
                ],
            ],
            [
                'en' => [
                    'title' => 'Third Post Title',
                    'slug' => 'third-post-title',
                    'description' => $desc['en'],
                    'content' => $content['en'],
                ],
                'id' => [
                    'title' => 'Judul Post Ketiga',
                    'slug' => 'judul-post-ketiga',
                    'description' => $desc['id'],
                    'content' => $content['id'],
                ],
            ],
        ];

        foreach ($posts as $postData) {
            $post = Post::create([
                'user_id' => $users->random(), // Pilih user_id secara acak
                'category_id' => $categories->random(), // Pilih category_id secara acak
            ]);

            $post->translateOrNew('en')->title = $postData['en']['title'];
            $post->translateOrNew('en')->slug = $postData['en']['slug'];
            $post->translateOrNew('en')->description = $postData['en']['description'];
            $post->translateOrNew('en')->content = $postData['en']['content'];

            $post->translateOrNew('id')->title = $postData['id']['title'];
            $post->translateOrNew('id')->slug = $postData['id']['slug'];
            $post->translateOrNew('id')->description = $postData['id']['description'];
            $post->translateOrNew('id')->content = $postData['id']['content'];

            $post->save();
        }
    }
}
