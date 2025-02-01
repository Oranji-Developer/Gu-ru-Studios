import { Button } from "@/components/ui/button";
import { CardCourse } from "@/components/CardCourse";
import React from "react";
import { usePage, router } from "@inertiajs/react";
import { Course } from "@/types/Course";
import { useState } from "react";

export const CourseSection = () => {
    const page = usePage();
    const courses = page.props.courses as Course[];
    const filterFields = page.props.courseTypes as string[];

    const [type, setType] = useState((page.props.course_type as string) ?? "");

    function filterCourse(key: string) {
        router.get(
            page.url,
            {
                course_type: key,
            },
            {
                preserveScroll: true,
                preserveState: true,
            }
        );
    }

    const akronyms: { [key: string]: string } = {
        abk: "Anak Berkebutuhan Khusus",
    };

    function handleConvertionName(name: string) {
        if (akronyms[name]) {
            return akronyms[name];
        }
        return name.charAt(0).toUpperCase() + name.slice(1);
    }

    function selectType(type: string) {
        setType(type);
        filterCourse(type);
    }

    return (
        <section className="">
            <div className="header flex justify-between items-center mb-12">
                <h1 className="text-[3.5rem] font-semibold leading-[120%]">
                    Jelajahi beberapa kelas <br />
                    <span className="text-primary"> Gu Ru Studios</span>
                </h1>
                <p className="w-[31.25rem] text-gray-500 text-2xl leading-[120%]">
                    Selamat datang di Katalog Kursus kami! Temukan beragam kelas
                    yang dirancang untuk membantu Anda memperoleh keterampilan
                    baru dan mencapai tujuan pribadi Anda.
                </p>
            </div>
            <div className="filter flex justify-between items-center mb-12">
                <div className="bg-gray-100 p-2 rounded-full border">
                    <div className="flex gap-1">
                        <Button
                            key="all"
                            variant={!type ? "default" : "ghost"}
                            className="py-2 px-4 rounded-full shadow-none"
                            onClick={() => selectType("")}
                        >
                            Semua
                        </Button>
                        {filterFields.map((filter) => (
                            <Button
                                key={filter}
                                variant={filter === type ? "default" : "ghost"}
                                onClick={() => selectType(filter)}
                                className={`${
                                    filter === type ? "" : "hover:text-gray-500"
                                } py-2 px-4 shadow-none rounded-full`}
                            >
                                {handleConvertionName(filter)}
                            </Button>
                        ))}
                    </div>
                </div>
                <Button
                    variant={"outline"}
                    className="rounded-full text-primary border-primary"
                    size={"xl"}
                    onClick={() => router.visit(route("courses"))}
                >
                    Lihat Semua
                </Button>
            </div>
            <div className="content grid grid-cols-2 xl lg:grid-cols-3 2xl:grid-cols-4 items-center justify-items-center gap-8">
                {courses.map((course, index) => (
                    <CardCourse
                        category={course.course_type}
                        key={index}
                        title={course.title}
                        thumbnail={"/storage/" + course.thumbnail}
                        rate={4.5}
                        applied={5200}
                        price={course.cost}
                        discount={course.disc}
                    ></CardCourse>
                ))}
            </div>
        </section>
    );
};
