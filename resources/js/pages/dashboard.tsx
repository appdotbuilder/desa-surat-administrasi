import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { type BreadcrumbItem } from '@/types';

interface Stats {
    incoming_letters: {
        total: number;
        new: number;
        processed: number;
        disposed: number;
    };
    outgoing_letters: {
        total: number;
        draft: number;
        sent: number;
    };
    dispositions: {
        total: number;
        pending: number;
        in_progress: number;
        completed: number;
        overdue: number;
    };
    archives: {
        total: number;
        incoming: number;
        outgoing: number;
    };
    users: {
        total: number;
        active: number;
    };
}

interface RecentActivities {
    incoming_letters: Array<{
        id: number;
        letter_number: string;
        sender: string;
        subject: string;
        created_at: string;
    }>;
    outgoing_letters: Array<{
        id: number;
        letter_number: string;
        recipient: string;
        subject: string;
        created_at: string;
    }>;
    dispositions: Array<{
        id: number;
        incoming_letter: {
            letter_number: string;
            subject: string;
        };
        assigned_to: {
            name: string;
        };
        status: string;
        created_at: string;
    }>;
}

interface Props {
    stats: Stats;
    recent_activities: RecentActivities;
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard({ stats, recent_activities }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard - SIADESA" />
            <div className="flex h-full flex-1 flex-col gap-6 rounded-xl p-6 overflow-x-auto">
                {/* Header */}
                <div>
                    <h1 className="text-2xl font-bold text-foreground flex items-center space-x-2">
                        <span>📊</span>
                        <span>Dashboard SIADESA</span>
                    </h1>
                    <p className="text-muted-foreground">
                        Ringkasan sistem informasi administrasi surat desa
                    </p>
                </div>

                {/* Quick Stats Grid */}
                <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                    {/* Surat Masuk */}
                    <div className="rounded-lg border bg-card text-card-foreground shadow-sm p-6">
                        <div className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <h3 className="tracking-tight text-sm font-medium">Surat Masuk</h3>
                            <span className="text-2xl">📨</span>
                        </div>
                        <div>
                            <div className="text-2xl font-bold">{stats.incoming_letters.total}</div>
                            <p className="text-xs text-muted-foreground">
                                {stats.incoming_letters.new} baru, {stats.incoming_letters.processed} diproses
                            </p>
                        </div>
                    </div>

                    {/* Surat Keluar */}
                    <div className="rounded-lg border bg-card text-card-foreground shadow-sm p-6">
                        <div className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <h3 className="tracking-tight text-sm font-medium">Surat Keluar</h3>
                            <span className="text-2xl">📤</span>
                        </div>
                        <div>
                            <div className="text-2xl font-bold">{stats.outgoing_letters.total}</div>
                            <p className="text-xs text-muted-foreground">
                                {stats.outgoing_letters.draft} draft, {stats.outgoing_letters.sent} terkirim
                            </p>
                        </div>
                    </div>

                    {/* Disposisi */}
                    <div className="rounded-lg border bg-card text-card-foreground shadow-sm p-6">
                        <div className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <h3 className="tracking-tight text-sm font-medium">Disposisi</h3>
                            <span className="text-2xl">📋</span>
                        </div>
                        <div>
                            <div className="text-2xl font-bold">{stats.dispositions.total}</div>
                            <p className="text-xs text-muted-foreground">
                                {stats.dispositions.pending} pending, {stats.dispositions.overdue} terlambat
                            </p>
                        </div>
                    </div>

                    {/* Arsip */}
                    <div className="rounded-lg border bg-card text-card-foreground shadow-sm p-6">
                        <div className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <h3 className="tracking-tight text-sm font-medium">Arsip</h3>
                            <span className="text-2xl">🗂️</span>
                        </div>
                        <div>
                            <div className="text-2xl font-bold">{stats.archives.total}</div>
                            <p className="text-xs text-muted-foreground">
                                {stats.archives.incoming} masuk, {stats.archives.outgoing} keluar
                            </p>
                        </div>
                    </div>
                </div>

                {/* Quick Actions */}
                <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <div className="rounded-lg border bg-card p-6">
                        <h3 className="text-lg font-semibold mb-4 flex items-center space-x-2">
                            <span>⚡</span>
                            <span>Aksi Cepat</span>
                        </h3>
                        <div className="space-y-2">
                            <Link href="/incoming-letters/create" className="block">
                                <Button variant="outline" className="w-full justify-start">
                                    📨 Tambah Surat Masuk
                                </Button>
                            </Link>
                            <Link href="/outgoing-letters/create" className="block">
                                <Button variant="outline" className="w-full justify-start">
                                    📤 Buat Surat Keluar
                                </Button>
                            </Link>
                            <Link href="/dispositions/create" className="block">
                                <Button variant="outline" className="w-full justify-start">
                                    📋 Buat Disposisi
                                </Button>
                            </Link>
                        </div>
                    </div>

                    {/* Status Overview */}
                    <div className="rounded-lg border bg-card p-6">
                        <h3 className="text-lg font-semibold mb-4 flex items-center space-x-2">
                            <span>📈</span>
                            <span>Status Disposisi</span>
                        </h3>
                        <div className="space-y-3">
                            <div className="flex justify-between items-center">
                                <span className="text-sm text-gray-600">Pending</span>
                                <span className="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">
                                    {stats.dispositions.pending}
                                </span>
                            </div>
                            <div className="flex justify-between items-center">
                                <span className="text-sm text-gray-600">In Progress</span>
                                <span className="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">
                                    {stats.dispositions.in_progress}
                                </span>
                            </div>
                            <div className="flex justify-between items-center">
                                <span className="text-sm text-gray-600">Completed</span>
                                <span className="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">
                                    {stats.dispositions.completed}
                                </span>
                            </div>
                            <div className="flex justify-between items-center">
                                <span className="text-sm text-red-600">Overdue</span>
                                <span className="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">
                                    {stats.dispositions.overdue}
                                </span>
                            </div>
                        </div>
                    </div>

                    {/* System Info */}
                    <div className="rounded-lg border bg-card p-6">
                        <h3 className="text-lg font-semibold mb-4 flex items-center space-x-2">
                            <span>👥</span>
                            <span>Sistem</span>
                        </h3>
                        <div className="space-y-3">
                            <div className="flex justify-between items-center">
                                <span className="text-sm text-gray-600">Total Pengguna</span>
                                <span className="font-semibold">{stats.users.total}</span>
                            </div>
                            <div className="flex justify-between items-center">
                                <span className="text-sm text-gray-600">Pengguna Aktif</span>
                                <span className="font-semibold">{stats.users.active}</span>
                            </div>
                            <div className="pt-2">
                                <Link href="/users">
                                    <Button variant="outline" size="sm" className="w-full">
                                        👥 Kelola Pengguna
                                    </Button>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Recent Activities */}
                <div className="grid gap-6 lg:grid-cols-2">
                    {/* Recent Incoming Letters */}
                    <div className="rounded-lg border bg-card p-6">
                        <div className="flex justify-between items-center mb-4">
                            <h3 className="text-lg font-semibold flex items-center space-x-2">
                                <span>📨</span>
                                <span>Surat Masuk Terbaru</span>
                            </h3>
                            <Link href="/incoming-letters">
                                <Button variant="ghost" size="sm">Lihat Semua</Button>
                            </Link>
                        </div>
                        <div className="space-y-3">
                            {recent_activities.incoming_letters.map((letter) => (
                                <div key={letter.id} className="flex justify-between items-start p-3 bg-gray-50 rounded-lg">
                                    <div className="flex-1">
                                        <div className="font-medium text-sm">{letter.letter_number}</div>
                                        <div className="text-sm text-gray-600">{letter.sender}</div>
                                        <div className="text-xs text-gray-500 truncate">{letter.subject}</div>
                                    </div>
                                    <div className="text-xs text-gray-500">
                                        {new Date(letter.created_at).toLocaleDateString('id-ID')}
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>

                    {/* Recent Dispositions */}
                    <div className="rounded-lg border bg-card p-6">
                        <div className="flex justify-between items-center mb-4">
                            <h3 className="text-lg font-semibold flex items-center space-x-2">
                                <span>📋</span>
                                <span>Disposisi Terbaru</span>
                            </h3>
                            <Link href="/dispositions">
                                <Button variant="ghost" size="sm">Lihat Semua</Button>
                            </Link>
                        </div>
                        <div className="space-y-3">
                            {recent_activities.dispositions.map((disposition) => (
                                <div key={disposition.id} className="flex justify-between items-start p-3 bg-gray-50 rounded-lg">
                                    <div className="flex-1">
                                        <div className="font-medium text-sm">{disposition.incoming_letter.letter_number}</div>
                                        <div className="text-sm text-gray-600">→ {disposition.assigned_to.name}</div>
                                        <div className="text-xs text-gray-500 truncate">{disposition.incoming_letter.subject}</div>
                                    </div>
                                    <div className="text-right">
                                        <span className={`px-2 py-1 rounded-full text-xs ${
                                            disposition.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                            disposition.status === 'in_progress' ? 'bg-blue-100 text-blue-800' :
                                            'bg-green-100 text-green-800'
                                        }`}>
                                            {disposition.status}
                                        </span>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}