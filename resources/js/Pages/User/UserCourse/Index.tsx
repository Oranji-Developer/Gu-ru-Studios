import { CustomerLayout } from "@/Layouts/CustomerLayout";
import { Pagination } from "@/types/util/Pagination";
import { UserCourse } from "@/types/model/UserCourse";
import { usePage, Head, router } from "@inertiajs/react";
import { Pagination as PaginationComp } from "@/components/Pagination";
import { Button } from "@/components/ui/button";
import { useState } from "react";

export default function Index() {
    const page = usePage().props;
    const userCourses = page.data as {
        data: UserCourse[];
    } & Pagination;
    const statusFields = page.statusFields as string[];

    const [type, setType] = useState("");

    function searchCourse(search?: string, filter?: string, status?: string) {
        router.get(
            route("user.course.index"),
            {
                filter: filter,
            },
            {
                preserveState: true,
                replace: true,
            }
        );
    }

    function selectType(type: string) {
        setType(type);
        searchCourse("", type);
    }

    return (
        <CustomerLayout>
            <Head title="Kelas Saya" />
            <header className="text-4xl font-medium">Kelas Saya</header>
            <section className="py-6">
                <div className="bg-gray-100 p-1 rounded-md inline-flex gap-1">
                    <Button
                        key="all"
                        variant={!type ? "default" : "ghost"}
                        type="button"
                        className={`${!type ? "" : ""}`}
                        onClick={() => selectType("")}
                    >
                        Semua
                    </Button>
                    {statusFields.map((element) => (
                        <Button
                            key={element}
                            variant={element === type ? "default" : "ghost"}
                            className={`${
                                element === type ? "" : "hover:text-gray-500"
                            }`}
                            type="button"
                            onClick={() => {
                                selectType(element);
                            }}
                        >
                            {element}
                        </Button>
                    ))}
                </div>
                <div className="py-4">
                    {userCourses.data.map((userCourse) => (
                        <div
                            key={userCourse.course.id}
                            className="flex gap-6 items-stretch"
                        >
                            <div className="thumbnail w-[15.625rem] h-[10.625rem]">
                                <img
                                    className="rounded-lg"
                                    src={
                                        "/storage/" +
                                        userCourse.course.thumbnail
                                    }
                                    alt=""
                                />
                            </div>
                            <div className="detail-info py-2">
                                <h4 className="text-sm">{userCourse.status}</h4>
                                <h1 className="text-4xl font-medium">
                                    {userCourse.course.title}
                                </h1>
                                <div className="flex gap-2 text-lg py-2">
                                    <h6 className="">
                                        {userCourse.course.mentor.name}
                                    </h6>
                                    <h6 className=" border-l-2 pl-2 border-purple-300">
                                        {userCourse.course.course_type}
                                    </h6>
                                </div>
                                <h3 className="font-light text-gray-500">
                                    Berakhir pada {userCourse.end_date}
                                </h3>
                            </div>
                        </div>
                    ))}
                </div>
                <div>
                    <PaginationComp
                        from={userCourses.from}
                        per_page={userCourses.per_page}
                        to={userCourses.to}
                        total={userCourses.total}
                        firstPageUrl={userCourses.first_page_url}
                        lastPageUrl={userCourses.last_page_url}
                        links={userCourses.links}
                    />
                </div>
            </section>
        </CustomerLayout>
    );
}
