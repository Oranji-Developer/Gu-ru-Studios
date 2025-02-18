import { AdminLayout } from "@/Layouts/AdminLayout";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import { usePage } from "@inertiajs/react";
import { CustomerLayout } from "@/Layouts/CustomerLayout";
import DashboardAdmin from "@/Pages/Admin/Dashboard";
import DashboardCustomer from "@/Pages/Customer/Dashboard";

export default function DashboardRole() {
    const user = usePage().props.auth.user;
    if (user.role === "admin") {
        return (
            <AdminLayout
                header={
                    <h2 className="text-[2rem] font-medium leading-tight text-primary">
                        Improve Your Business
                    </h2>
                }
            >
                <DashboardAdmin />
            </AdminLayout>
        );
    } else if (user.role === "customer") {
        return (
            <CustomerLayout
                header={
                    <h2 className="text-[2rem] font-medium leading-tight text-primary">
                        Exemine Your Improvement
                    </h2>
                }
            >
                <DashboardCustomer />
            </CustomerLayout>
        );
    } else {
        return (
            <AuthenticatedLayout
                header={
                    <h2 className="text-[2rem] font-medium leading-tight text-primary">
                        Dashboard
                    </h2>
                }
            >
                <Head title="Dashboard" />
                <div>
                    <h1 className="text-2xl font-semibold leading-[1.8rem]">
                        Dashboard
                    </h1>
                    <p className="text-sm leading-[1.05rem] text-gray-400">
                        Welcome to your dashboard.
                    </p>
                </div>
            </AuthenticatedLayout>
        );
    }
}
