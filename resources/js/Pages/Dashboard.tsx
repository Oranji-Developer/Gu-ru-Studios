import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { Head } from "@inertiajs/react";

export default function Dashboard() {
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-[2rem] font-medium leading-tight text-primary">
                    Dashboard
                </h2>
            }
        >
            <Head title="Dashboard" />

            <div className="py-2">
                <section className="mx-auto max-w-8xl sm:px-6 lg:px-16">
                    <Tabs defaultValue="overview" className="w-[400px]">
                        <TabsList>
                            <TabsTrigger value="overview">Overview</TabsTrigger>
                            <TabsTrigger value="analytics">
                                Analytics
                            </TabsTrigger>
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
            </div>
        </AuthenticatedLayout>
    );
}
