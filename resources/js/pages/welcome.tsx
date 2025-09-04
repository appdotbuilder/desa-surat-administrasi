import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

interface Props {
    canLogin: boolean;
    canRegister: boolean;
    [key: string]: unknown;
}

export default function Welcome({ canLogin, canRegister }: Props) {
    return (
        <>
            <Head title="SIADESA - Sistem Informasi Administrasi Surat Desa" />
            
            <div className="min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50">
                {/* Navigation */}
                <nav className="bg-white/80 backdrop-blur-sm border-b border-gray-200 sticky top-0 z-50">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="flex justify-between items-center h-16">
                            <div className="flex items-center space-x-3">
                                <div className="w-10 h-10 bg-gradient-to-br from-blue-600 to-green-600 rounded-lg flex items-center justify-center">
                                    <span className="text-white font-bold text-lg">📧</span>
                                </div>
                                <div>
                                    <h1 className="text-xl font-bold text-gray-900">SIADESA</h1>
                                    <p className="text-xs text-gray-500">Sistem Administrasi Surat Desa</p>
                                </div>
                            </div>
                            
                            {canLogin && (
                                <div className="flex items-center space-x-4">
                                    <Link href="/login">
                                        <Button variant="ghost">Masuk</Button>
                                    </Link>
                                    {canRegister && (
                                        <Link href="/register">
                                            <Button>Daftar</Button>
                                        </Link>
                                    )}
                                </div>
                            )}
                        </div>
                    </div>
                </nav>

                {/* Hero Section */}
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                    <div className="text-center">
                        <div className="inline-flex items-center space-x-2 bg-blue-100 text-blue-800 px-4 py-2 rounded-full mb-6">
                            <span className="text-2xl">🏛️</span>
                            <span className="font-medium">Administrasi Desa Digital</span>
                        </div>
                        
                        <h1 className="text-4xl sm:text-6xl font-bold text-gray-900 mb-6">
                            <span className="bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent">
                                SIADESA
                            </span>
                        </h1>
                        
                        <p className="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                            Sistem Informasi Administrasi Surat Desa yang modern dan efisien untuk mengelola seluruh aktivitas persuratan di kantor desa Anda.
                        </p>

                        {canLogin && (
                            <div className="flex justify-center space-x-4">
                                <Link href="/dashboard">
                                    <Button size="lg" className="bg-gradient-to-r from-blue-600 to-green-600 text-white px-8">
                                        🚀 Mulai Sekarang
                                    </Button>
                                </Link>
                                <Link href="/login">
                                    <Button size="lg" variant="outline">
                                        📊 Lihat Demo
                                    </Button>
                                </Link>
                            </div>
                        )}
                    </div>
                </div>

                {/* Features Grid */}
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                    <div className="text-center mb-16">
                        <h2 className="text-3xl font-bold text-gray-900 mb-4">✨ Fitur Lengkap SIADESA</h2>
                        <p className="text-lg text-gray-600">Semua yang Anda butuhkan untuk mengelola administrasi surat desa</p>
                    </div>

                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {/* Surat Masuk */}
                        <div className="bg-white rounded-2xl p-8 shadow-lg border hover:shadow-xl transition-shadow">
                            <div className="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                                <span className="text-3xl">📨</span>
                            </div>
                            <h3 className="text-xl font-semibold text-gray-900 mb-3">Surat Masuk</h3>
                            <p className="text-gray-600 mb-4">Pencatatan dan pengelolaan surat masuk dengan sistem tracking yang akurat dan real-time.</p>
                            <ul className="space-y-2 text-sm text-gray-500">
                                <li>✓ Input data surat otomatis</li>
                                <li>✓ Tracking status surat</li>
                                <li>✓ Notifikasi real-time</li>
                            </ul>
                        </div>

                        {/* Surat Keluar */}
                        <div className="bg-white rounded-2xl p-8 shadow-lg border hover:shadow-xl transition-shadow">
                            <div className="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center mb-6">
                                <span className="text-3xl">📤</span>
                            </div>
                            <h3 className="text-xl font-semibold text-gray-900 mb-3">Surat Keluar</h3>
                            <p className="text-gray-600 mb-4">Membuat dan mengelola surat keluar dengan template yang dapat disesuaikan.</p>
                            <ul className="space-y-2 text-sm text-gray-500">
                                <li>✓ Template surat otomatis</li>
                                <li>✓ Editor surat terintegrasi</li>
                                <li>✓ Approval workflow</li>
                            </ul>
                        </div>

                        {/* Disposisi */}
                        <div className="bg-white rounded-2xl p-8 shadow-lg border hover:shadow-xl transition-shadow">
                            <div className="w-16 h-16 bg-yellow-100 rounded-xl flex items-center justify-center mb-6">
                                <span className="text-3xl">📋</span>
                            </div>
                            <h3 className="text-xl font-semibold text-gray-900 mb-3">Disposisi</h3>
                            <p className="text-gray-600 mb-4">Sistem disposisi surat dengan assignment dan tracking progress yang jelas.</p>
                            <ul className="space-y-2 text-sm text-gray-500">
                                <li>✓ Assignment otomatis</li>
                                <li>✓ Progress tracking</li>
                                <li>✓ Deadline monitoring</li>
                            </ul>
                        </div>

                        {/* Arsip */}
                        <div className="bg-white rounded-2xl p-8 shadow-lg border hover:shadow-xl transition-shadow">
                            <div className="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                                <span className="text-3xl">🗂️</span>
                            </div>
                            <h3 className="text-xl font-semibold text-gray-900 mb-3">Arsip Digital</h3>
                            <p className="text-gray-600 mb-4">Sistem pengarsipan digital yang aman dengan pencarian cepat dan kategorisasi.</p>
                            <ul className="space-y-2 text-sm text-gray-500">
                                <li>✓ Penyimpanan aman</li>
                                <li>✓ Pencarian cepat</li>
                                <li>✓ Backup otomatis</li>
                            </ul>
                        </div>

                        {/* Dashboard */}
                        <div className="bg-white rounded-2xl p-8 shadow-lg border hover:shadow-xl transition-shadow">
                            <div className="w-16 h-16 bg-red-100 rounded-xl flex items-center justify-center mb-6">
                                <span className="text-3xl">📊</span>
                            </div>
                            <h3 className="text-xl font-semibold text-gray-900 mb-3">Dashboard</h3>
                            <p className="text-gray-600 mb-4">Ringkasan informasi dan statistik lengkap dalam satu tampilan yang intuitif.</p>
                            <ul className="space-y-2 text-sm text-gray-500">
                                <li>✓ Statistik real-time</li>
                                <li>✓ Grafik interaktif</li>
                                <li>✓ Summary reports</li>
                            </ul>
                        </div>

                        {/* User Management */}
                        <div className="bg-white rounded-2xl p-8 shadow-lg border hover:shadow-xl transition-shadow">
                            <div className="w-16 h-16 bg-indigo-100 rounded-xl flex items-center justify-center mb-6">
                                <span className="text-3xl">👥</span>
                            </div>
                            <h3 className="text-xl font-semibold text-gray-900 mb-3">Manajemen User</h3>
                            <p className="text-gray-600 mb-4">Kelola pengguna sistem dengan role-based access control yang fleksibel.</p>
                            <ul className="space-y-2 text-sm text-gray-500">
                                <li>✓ Role management</li>
                                <li>✓ Access control</li>
                                <li>✓ Activity logging</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {/* Benefits Section */}
                <div className="bg-gradient-to-r from-blue-600 to-green-600 text-white py-20">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                        <h2 className="text-3xl font-bold mb-4">🎯 Mengapa Memilih SIADESA?</h2>
                        <p className="text-xl opacity-90 mb-12">Solusi terdepan untuk administrasi desa yang modern</p>
                        
                        <div className="grid md:grid-cols-3 gap-8">
                            <div className="text-center">
                                <div className="text-4xl mb-4">⚡</div>
                                <h3 className="text-xl font-semibold mb-2">Efisiensi Tinggi</h3>
                                <p className="opacity-90">Otomatisasi proses administrasi surat untuk menghemat waktu dan tenaga petugas desa.</p>
                            </div>
                            <div className="text-center">
                                <div className="text-4xl mb-4">🔒</div>
                                <h3 className="text-xl font-semibold mb-2">Keamanan Data</h3>
                                <p className="opacity-90">Sistem keamanan berlapis dengan backup otomatis untuk melindungi data penting desa.</p>
                            </div>
                            <div className="text-center">
                                <div className="text-4xl mb-4">📱</div>
                                <h3 className="text-xl font-semibold mb-2">User Friendly</h3>
                                <p className="opacity-90">Interface yang intuitif dan mudah digunakan oleh seluruh petugas administrasi desa.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {/* CTA Section */}
                <div className="bg-white py-20">
                    <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                        <h2 className="text-3xl font-bold text-gray-900 mb-4">🚀 Siap Memulai?</h2>
                        <p className="text-lg text-gray-600 mb-8">
                            Bergabunglah dengan desa-desa lain yang telah merasakan manfaat SIADESA
                        </p>
                        
                        {canLogin && (
                            <div className="flex justify-center space-x-4">
                                <Link href="/register">
                                    <Button size="lg" className="bg-gradient-to-r from-blue-600 to-green-600 text-white px-8">
                                        📝 Daftar Sekarang
                                    </Button>
                                </Link>
                                <Link href="/login">
                                    <Button size="lg" variant="outline">
                                        🔐 Login ke Sistem
                                    </Button>
                                </Link>
                            </div>
                        )}
                    </div>
                </div>

                {/* Footer */}
                <footer className="bg-gray-900 text-white py-12">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center">
                            <div className="flex items-center justify-center space-x-3 mb-4">
                                <div className="w-8 h-8 bg-gradient-to-br from-blue-600 to-green-600 rounded-lg flex items-center justify-center">
                                    <span className="text-white text-sm">📧</span>
                                </div>
                                <h3 className="text-lg font-semibold">SIADESA</h3>
                            </div>
                            <p className="text-gray-400 mb-4">
                                Sistem Informasi Administrasi Surat Desa - Digitalisasi untuk Desa yang Lebih Maju
                            </p>
                            <p className="text-sm text-gray-500">
                                © 2024 SIADESA. Semua hak cipta dilindungi. 🏛️ Untuk kemajuan administrasi desa Indonesia.
                            </p>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}