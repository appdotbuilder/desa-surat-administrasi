import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { type BreadcrumbItem } from '@/types';

interface IncomingLetter {
    id: number;
    letter_number: string;
    sender: string;
    subject: string;
    letter_date: string;
    received_date: string;
    priority: 'low' | 'medium' | 'high';
    status: 'new' | 'processed' | 'disposed' | 'archived';
    creator: {
        name: string;
    };
}

interface Props {
    incoming_letters: {
        data: IncomingLetter[];
        links: Array<{
            url?: string;
            label: string;
            active: boolean;
        }>;
    };
    filters: {
        status?: string;
        priority?: string;
        search?: string;
    };
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Surat Masuk', href: '/incoming-letters' },
];

const priorityLabels = {
    low: { label: 'Rendah', class: 'bg-gray-100 text-gray-800' },
    medium: { label: 'Sedang', class: 'bg-blue-100 text-blue-800' },
    high: { label: 'Tinggi', class: 'bg-red-100 text-red-800' },
};

const statusLabels = {
    new: { label: 'Baru', class: 'bg-green-100 text-green-800' },
    processed: { label: 'Diproses', class: 'bg-yellow-100 text-yellow-800' },
    disposed: { label: 'Didisposisi', class: 'bg-blue-100 text-blue-800' },
    archived: { label: 'Diarsipkan', class: 'bg-gray-100 text-gray-800' },
};

export default function Index({ incoming_letters }: Props) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Surat Masuk - SIADESA" />
            <div className="flex h-full flex-1 flex-col gap-6 rounded-xl p-6 overflow-x-auto">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-2xl font-bold flex items-center space-x-2">
                            <span>📨</span>
                            <span>Surat Masuk</span>
                        </h1>
                        <p className="text-muted-foreground">
                            Kelola dan pantau surat masuk kantor desa
                        </p>
                    </div>
                    <Link href="/incoming-letters/create">
                        <Button className="bg-blue-600 hover:bg-blue-700">
                            ➕ Tambah Surat Masuk
                        </Button>
                    </Link>
                </div>

                {/* Filters */}
                <div className="flex flex-wrap gap-4 p-4 bg-white rounded-lg border">
                    <div className="flex items-center space-x-2">
                        <span className="text-sm font-medium">Filter:</span>
                        <select className="px-3 py-1 border rounded text-sm">
                            <option value="">Semua Status</option>
                            <option value="new">Baru</option>
                            <option value="processed">Diproses</option>
                            <option value="disposed">Didisposisi</option>
                            <option value="archived">Diarsipkan</option>
                        </select>
                        <select className="px-3 py-1 border rounded text-sm">
                            <option value="">Semua Prioritas</option>
                            <option value="high">Tinggi</option>
                            <option value="medium">Sedang</option>
                            <option value="low">Rendah</option>
                        </select>
                        <input 
                            type="text"
                            placeholder="Cari nomor surat, pengirim..."
                            className="px-3 py-1 border rounded text-sm"
                        />
                        <Button size="sm" variant="outline">🔍 Cari</Button>
                    </div>
                </div>

                {/* Letters Table */}
                <div className="bg-white rounded-lg border overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nomor Surat
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pengirim
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Perihal
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Prioritas
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody className="bg-white divide-y divide-gray-200">
                                {incoming_letters.data.map((letter) => (
                                    <tr key={letter.id} className="hover:bg-gray-50">
                                        <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {letter.letter_number}
                                        </td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {letter.sender}
                                        </td>
                                        <td className="px-6 py-4 text-sm text-gray-900 max-w-xs truncate">
                                            {letter.subject}
                                        </td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {new Date(letter.letter_date).toLocaleDateString('id-ID')}
                                        </td>
                                        <td className="px-6 py-4 whitespace-nowrap">
                                            <span className={`px-2 py-1 text-xs font-medium rounded-full ${priorityLabels[letter.priority].class}`}>
                                                {priorityLabels[letter.priority].label}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4 whitespace-nowrap">
                                            <span className={`px-2 py-1 text-xs font-medium rounded-full ${statusLabels[letter.status].class}`}>
                                                {statusLabels[letter.status].label}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <Link href={`/incoming-letters/${letter.id}`}>
                                                <Button size="sm" variant="outline">👁️ Lihat</Button>
                                            </Link>
                                            <Link href={`/incoming-letters/${letter.id}/edit`}>
                                                <Button size="sm" variant="outline">✏️ Edit</Button>
                                            </Link>
                                            {letter.status === 'processed' && (
                                                <Link href={`/dispositions/create?incoming_letter_id=${letter.id}`}>
                                                    <Button size="sm" className="bg-green-600 hover:bg-green-700">📋 Disposisi</Button>
                                                </Link>
                                            )}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>

                    {/* Pagination */}
                    <div className="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div className="flex-1 flex justify-between sm:hidden">
                            <Button variant="outline" disabled>Previous</Button>
                            <Button variant="outline" disabled>Next</Button>
                        </div>
                        <div className="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p className="text-sm text-gray-700">
                                    Menampilkan <span className="font-medium">1</span> sampai <span className="font-medium">10</span> dari{' '}
                                    <span className="font-medium">{incoming_letters.data.length}</span> hasil
                                </p>
                            </div>
                            <div>
                                <nav className="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    {incoming_letters.links.map((link, index) => (
                                        <button
                                            key={index}
                                            className={`relative inline-flex items-center px-4 py-2 border text-sm font-medium ${
                                                link.active 
                                                    ? 'z-10 bg-blue-50 border-blue-500 text-blue-600' 
                                                    : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'
                                            } ${index === 0 ? 'rounded-l-md' : ''} ${index === incoming_letters.links.length - 1 ? 'rounded-r-md' : ''}`}
                                            dangerouslySetInnerHTML={{ __html: link.label }}
                                        />
                                    ))}
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}