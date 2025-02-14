import { AdminLayout } from "@/Layouts/AdminLayout";
import { Head, useForm, usePage, router } from "@inertiajs/react";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import InputError from "@/components/InputError";
import { Button } from "@/components/ui/button";
import { CalendarIcon } from "@heroicons/react/24/solid";
import { DragDropPhoto } from "@/components/DragDropPhoto";
import { RadioGroup, RadioGroupItem } from "@/components/ui/radio-group";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/components/ui/popover";
import { Calendar } from "@/components/ui/calendar";
import { cn } from "@/lib/utils";
import { z } from "zod";
import { format, addDays } from "date-fns";
import React from "react";
import { EventSchema } from "@/lib/schema/EventSchema";
import { useState } from "react";
import { DateRange } from "react-day-picker";
import { handlingZodInputError } from "@/lib/utils/handlingInputError";
import { FormEventHandler } from "react";

export default function Create() {
    const page = usePage();

    const course_type = page.props.course_types as string[];
    const academic_class = page.props.academic_class as string[];
    const art_class = page.props.art_class as string[];
    const status = page.props.status as string[];

    const [classType, setClassType] = useState<string[]>([]);

    const [date, setDate] = useState<DateRange | undefined>({
        from: new Date(),
        to: addDays(new Date(), 7),
    });

    const { data, setData, post, processing, errors } = useForm<
        z.infer<typeof EventSchema.CREATE>
    >({
        title: "",
        thumbnail: null,
        desc: "",
        left_text: "",
        right_text: "",
    });

    async function handleDateChange() {
        setData("start_date", date?.from);
        setData("end_date", date?.to);
    }

    const submit: FormEventHandler = async (e) => {
        e.preventDefault();

        await handleDateChange();

        const dataParse = EventSchema.CREATE.safeParse(data);

        if (dataParse.success) {
            post(route("admin.event.store"), {
                forceFormData: true,
            });
        } else {
            handlingZodInputError(dataParse, errors);
            router.reload();
        }
    };

    return (
        <AdminLayout
            header={
                <div className="flex justify-between items-center">
                    <div>
                        <h1 className="text-2xl font-semibold leading-[1.8rem]">
                            Create Event
                        </h1>
                        <p className="text-sm leading-[1.05rem] text-gray-400">
                            Add new event to the list
                        </p>
                    </div>
                </div>
            }
        >
            <Head title="Create new event" />
            <form onSubmit={submit} className="pb-10 border-t">
                <section className="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-2">
                    <div className="flex flex-col gap-2">
                        <div>
                            <Label htmlFor="title">Nama Kelas</Label>
                            <Input
                                id="title"
                                title="title"
                                value={data.title}
                                placeholder="Masukkan Nama Kelas"
                                autoComplete="title"
                                onChange={(e) =>
                                    setData("title", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.title}
                                className="mt-2"
                            />
                        </div>
                        <div>
                            <Label htmlFor="title">Deskripsi Event</Label>
                            <Input
                                id="desc"
                                title="desc"
                                value={data.desc}
                                placeholder="Masukkan Deskripsi Event"
                                autoComplete="desc"
                                onChange={(e) =>
                                    setData("desc", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.desc}
                                className="mt-2"
                            />
                        </div>
                        <div>
                            <Label htmlFor="date">
                                Tanggal Mulai - Tanggal Berakhir
                            </Label>
                            <Popover>
                                <PopoverTrigger asChild>
                                    <Button
                                        id="date"
                                        variant={"outline"}
                                        className={cn(
                                            "w-full justify-start text-left font-normal",
                                            !date && "text-muted-foreground"
                                        )}
                                    >
                                        <CalendarIcon />
                                        {date?.from ? (
                                            date.to ? (
                                                <>
                                                    {format(
                                                        date.from,
                                                        "LLL dd, y"
                                                    )}{" "}
                                                    -{" "}
                                                    {format(
                                                        date.to,
                                                        "LLL dd, y"
                                                    )}
                                                </>
                                            ) : (
                                                format(date.from, "LLL dd, y")
                                            )
                                        ) : (
                                            <span>Pick a date</span>
                                        )}
                                    </Button>
                                </PopoverTrigger>
                                <PopoverContent
                                    className="w-auto p-0"
                                    align="start"
                                >
                                    <Calendar
                                        initialFocus
                                        mode="range"
                                        defaultMonth={date?.from}
                                        selected={date}
                                        onSelect={setDate}
                                        numberOfMonths={2}
                                    />
                                </PopoverContent>
                            </Popover>
                            <InputError
                                message={errors.start_date || errors.end_date}
                                className="mt-2"
                            />
                        </div>
                        <div className="">
                            <DragDropPhoto
                                errMessage={errors.thumbnail}
                                setData={(e) => {
                                    setData("thumbnail", e);
                                }}
                            />
                        </div>
                    </div>
                    <div className="flex flex-col gap-2">
                        <div>
                            <Label htmlFor="left_text">Tulisan Kiri</Label>
                            <Input
                                id="left_text"
                                title="left_text"
                                value={data.left_text}
                                placeholder="Masukkan Tulisan Kiri Event"
                                autoComplete="left_text"
                                onChange={(e) =>
                                    setData("left_text", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.left_text}
                                className="mt-2"
                            />
                        </div>
                        <div>
                            <Label htmlFor="right_text">Tulisan Kanan</Label>
                            <Input
                                id="right_text"
                                title="right_text"
                                value={data.right_text}
                                placeholder="Masukkan Tulisan Kanan Event"
                                autoComplete="right_text"
                                onChange={(e) =>
                                    setData("right_text", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.right_text}
                                className="mt-2"
                            />
                        </div>
                        <div>
                            <Label>Tipe Kelas</Label>
                            <RadioGroup
                                value={data.course_type}
                                defaultValue="male"
                                className="flex w-full gap-5"
                            >
                                {course_type.map((element) => (
                                    <Label
                                        htmlFor={element}
                                        key={element}
                                        className={`rounded-full focus:border-primary flex items-center space-x-2 w-full border border-input bg-background shadow-sm hover:bg-accent hover:text-accent-foreground px-5 py-3 ${
                                            data.course_type === element
                                                ? "border-primary text-primary bg-primary-foreground"
                                                : ""
                                        }`}
                                    >
                                        <RadioGroupItem
                                            onClick={() => {
                                                setData("course_type", element);
                                                if (element === "akademik") {
                                                    setClassType([
                                                        ...academic_class,
                                                    ]);
                                                } else if (element === "seni") {
                                                    setClassType([
                                                        ...art_class,
                                                    ]);
                                                } else {
                                                    setClassType([]);
                                                }
                                            }}
                                            value={element}
                                            id={element}
                                        />
                                        <Label htmlFor={element}>
                                            {element.charAt(0).toUpperCase() +
                                                element.slice(1)}
                                        </Label>
                                    </Label>
                                ))}
                            </RadioGroup>

                            <InputError
                                message={errors.course_type}
                                className="mt-2"
                            />
                        </div>

                        {classType.length > 0 && (
                            <div>
                                <Label>Jenis Kelas</Label>
                                <Select
                                    onValueChange={(e) => setData("class", e)}
                                >
                                    <SelectTrigger className="">
                                        <SelectValue placeholder="Jenis Kelas" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {classType.map((element) => (
                                            <SelectItem
                                                value={element}
                                                key={element}
                                            >
                                                {element}
                                            </SelectItem>
                                        ))}
                                    </SelectContent>
                                </Select>

                                <InputError
                                    message={errors.class}
                                    className="mt-2"
                                />
                            </div>
                        )}

                        <div className="w-full">
                            <Label>Status</Label>
                            <RadioGroup
                                value={data.status}
                                defaultValue="male"
                                className="flex w-full gap-5"
                            >
                                {status.map((element) => (
                                    <Label
                                        htmlFor={element}
                                        key={element}
                                        className={`rounded-full focus:border-primary flex items-center space-x-2 w-full border border-input bg-background shadow-sm hover:bg-accent hover:text-accent-foreground px-5 py-3 ${
                                            data.status === element
                                                ? "border-primary text-primary bg-primary-foreground"
                                                : ""
                                        }`}
                                    >
                                        <RadioGroupItem
                                            onClick={() =>
                                                setData("status", element)
                                            }
                                            value={element}
                                            id={element}
                                        />
                                        <Label htmlFor={element}>
                                            {element.charAt(0).toUpperCase() +
                                                element.slice(1)}
                                        </Label>
                                    </Label>
                                ))}
                            </RadioGroup>

                            <InputError
                                message={errors.status}
                                className="mt-2"
                            />
                        </div>
                    </div>
                </section>
                <div className="mt-4 flex justify-end gap-4">
                    <Button
                        type="button"
                        variant="outline"
                        onClick={() => router.visit(route("admin.event.index"))}
                    >
                        Batal Menambahkan Kelas
                    </Button>
                    <Button disabled={processing}>Simpan Kelas</Button>
                </div>
            </form>
        </AdminLayout>
    );
}
