import { AdminLayout } from "@/Layouts/AdminLayout";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { toast } from "@/hooks/use-toast";
import { Head, usePage, router } from "@inertiajs/react";

export default function Dashboard() {
    return (
        <section className="py-2">
            <Head title="Dashboard" />
            <Tabs defaultValue="overview" className="w-[400px]">
                <TabsList>
                    <TabsTrigger value="overview">Overview</TabsTrigger>
                    <TabsTrigger value="analytics">Analytics</TabsTrigger>
                    <TabsTrigger value="reports">Reports</TabsTrigger>
                    <TabsTrigger value="notifications">
                        Notifications
                    </TabsTrigger>
                </TabsList>
                <TabsContent value="overview">
                    Welcome to your dashboard.
                </TabsContent>
                <TabsContent value="analytics">
                    Take a look a detail of analytics.
                </TabsContent>
                <TabsContent value="reports">
                    View your reports here.
                </TabsContent>
                <TabsContent value="notifications">
                    Manage your notifications here.
                </TabsContent>
            </Tabs>
        </section>
    );
}
