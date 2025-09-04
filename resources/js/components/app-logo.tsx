

export default function AppLogo() {
    return (
        <>
            <div className="flex aspect-square size-8 items-center justify-center rounded-md bg-gradient-to-br from-blue-600 to-green-600 text-white">
                <span className="text-lg font-bold">📧</span>
            </div>
            <div className="ml-1 grid flex-1 text-left text-sm">
                <span className="mb-0.5 truncate leading-tight font-semibold">SIADESA</span>
                <span className="truncate text-xs text-muted-foreground">Sistem Administrasi Desa</span>
            </div>
        </>
    );
}