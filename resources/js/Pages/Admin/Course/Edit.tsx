import {AdminLayout} from "@/Layouts/AdminLayout";
import {Head, usePage} from "@inertiajs/react";
import {Input} from "@/components/ui/input";
import {Label} from "@/components/ui/label";
import InputError from "@/components/InputError";
import {useForm} from "@inertiajs/react";
import {z} from "zod";
import {CourseSchema} from "@/lib/schema/CourseSchema";
import {Mentor} from "@/types/Mentor";
import {Textarea} from "@/components/ui/textarea";
import {Checkbox} from "@/components/ui/checkbox";
import {RadioGroup, RadioGroupItem} from "@/components/ui/radio-group";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import {DragDropPhoto} from "@/components/DragDropPhoto";

import {Calendar} from "@/components/ui/calendar";
import {Button} from "@/components/ui/button";
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/components/ui/popover";

import {TimePicker} from "@/components/ui/time-picker";
import {DateRange} from "react-day-picker";
import {format, addDays} from "date-fns";
import {cn} from "@/lib/utils";
import {CalendarIcon} from "@heroicons/react/24/solid";
import {router} from "@inertiajs/react";
import {handlingZodInputError} from "@/lib/utils/handlingInputError";

import {useEffect, useState} from "react";
import {FormEventHandler} from "react";
import {Course} from "@/types/Course";
import {title} from "process";

export default function Edit() {
    const page = usePage();
    const dataFetch = page.props.data as Course;
    const mentors = page.props.mentor as Mentor[];
    const course_type = page.props.course_type as string[];
    const academic_class = page.props.academic_class as string[];
    const art_class = page.props.art_class as string[];
    const status = page.props.status as string[];

    function handleClassType(element: string) {
        if (element === "akademik") {
            return academic_class;
        } else if (element === "seni") {
            return art_class;
        } else {
            return [];
        }
    }

    const [classType, setClassType] = useState<string[]>(
        handleClassType(dataFetch.course_type)
    );

    const days = [
        "Senin",
        "Selasa",
        "Rabu",
        "Kamis",
        "Jumat",
        "Sabtu",
        "Minggu",
    ];

    const {data, setData, post, processing, errors} = useForm<
        z.infer<typeof CourseSchema.UPDATE>
    >({
        _method: "put",
        title: dataFetch.title,
        mentor_id: dataFetch.mentor_id,
        desc: dataFetch.desc,
        class: dataFetch.class,
        capacity: dataFetch.capacity,
        cost: dataFetch.cost,
        disc: dataFetch.disc,
        thumbnail: null,
        path: "/storage/" + dataFetch.thumbnail,
        course_type: dataFetch.course_type,
        status: dataFetch.status,
        day: dataFetch.schedule.day.split(","),
        time_start: handleTimeValue(dataFetch.schedule.start_time),
        time_end: handleTimeValue(dataFetch.schedule.end_time),
    });
    console.log(dataFetch);

    console.log(data);

    function handleTimeValue(time: string) {
        const [hours, minutes] = time.split(":");
        const now = new Date();
        now.setHours(parseInt(hours));
        now.setMinutes(parseInt(minutes));
        return now;
    }

    const [date, setDate] = useState<DateRange | undefined>({
        from: new Date(dataFetch.schedule.start_date),
        to: new Date(dataFetch.schedule.end_date),
    });

    function handleDateChange() {
        setData("start_date", date?.from);
        setData("end_date", date?.to);
        setData(
            "start_time",
            `${
                data.time_start.getHours()?.toString().length === 1
                    ? "0" + data.time_start.getHours()
                    : data.time_start.getHours()
            }:${
                data.time_start.getMinutes()?.toString().length === 1
                    ? "0" + data.time_start.getMinutes()
                    : data.time_start.getMinutes()
            }`
        );
        setData(
            "end_time",
            `${
                data.time_end.getHours()?.toString().length === 1
                    ? "0" + data.time_end.getHours()
                    : data.time_end.getHours()
            }:${
                data.time_end.getMinutes()?.toString().length === 1
                    ? "0" + data.time_end.getMinutes()
                    : data.time_end.getMinutes()
            }`
        );
        setData("total_meet", data.day.length);
    }

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        const dataParse = CourseSchema.UPDATE.safeParse(data);

        if (dataParse.success) {
            post(route("admin.course.update", {course: dataFetch.id}), {
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
                <div>
                    <h1 className="text-2xl font-semibold leading-[1.8rem]">
                        Edit Course
                    </h1>
                    <p className="text-sm leading-[1.05rem] text-gray-400">
                        Manage a edit course.
                    </p>
                </div>
            }
        >
            <Head title="Create Course"/>
            <form onSubmit={submit} className="pb-10">
                <section className="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-2">
                    <div className="">
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
                            <Label htmlFor="mentor">Mentor</Label>
                            <Select
                                value={
                                    mentors.find(
                                        (mentor) => mentor.id === data.mentor_id
                                    )?.name
                                }
                                onValueChange={(e) => {
                                    mentors.map((mentor) => {
                                        if (mentor.name === e) {
                                            setData("mentor_id", mentor.id);
                                        }
                                    });
                                }}
                            >
                                <SelectTrigger className="">
                                    <SelectValue placeholder="Mentor"/>
                                </SelectTrigger>
                                <SelectContent>
                                    {mentors.map((mentor) => (
                                        <SelectItem
                                            value={mentor.name}
                                            key={mentor.id}
                                        >
                                            {mentor.name} ({mentor.field})
                                        </SelectItem>
                                    ))}
                                </SelectContent>
                            </Select>
                            <InputError
                                message={errors.mentor_id}
                                className="mt-2"
                            />
                        </div>
                        <div>
                            <Label htmlFor="desc">Deskripsi</Label>
                            <Textarea
                                id="desc"
                                name="desc"
                                value={data.desc}
                                placeholder="Masukkan Deskripsi Kelas"
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
                            <Label htmlFor="date">Tanggal Mulai</Label>
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
                                        <CalendarIcon/>
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
                            <Label>Hari</Label>
                            <div className="grid grid-cols-3 gap-2">
                                {days.map((day) => (
                                    <Label htmlFor={day}
                                           className={cn(
                                               "flex items-center space-x-2 p-2 border rounded-md",
                                               data.day?.includes(day) &&
                                               "bg-primary-foreground text-primary border-primary"
                                           )}
                                           key={day}
                                    >
                                        <Checkbox
                                            id={day}
                                            key={day}
                                            checked={data.day?.includes(day)}
                                            onCheckedChange={(checked) => {
                                                checked
                                                    ? setData("day", [
                                                        ...data.day,
                                                        day,
                                                    ])
                                                    : setData(
                                                        "day",
                                                        data.day.filter(
                                                            (d: string) =>
                                                                d !== day
                                                        )
                                                    );
                                            }}
                                        />
                                        <Label htmlFor={day}>{day}</Label>
                                    </Label>
                                ))}
                            </div>
                            <InputError message={errors.day} className="mt-2"/>
                        </div>
                        <div>
                            <Label htmlFor="time">Waktu</Label>
                            <div className="grid grid-cols-2 gap-2">
                                <Popover>
                                    <PopoverTrigger asChild>
                                        <Button
                                            variant={"outline"}
                                            className={cn(
                                                "w-full justify-start text-left font-normal",
                                                !data.time_start &&
                                                "text-muted-foreground"
                                            )}
                                        >
                                            {data.time_start
                                                ? format(data.time_start, "p")
                                                : "Waktu Mulai"}
                                        </Button>
                                    </PopoverTrigger>
                                    <PopoverContent className="w-auto p-0">
                                        <TimePicker
                                            data={data.time_start}
                                            setData={(date) =>
                                                setData("time_start", date)
                                            }
                                        />
                                    </PopoverContent>
                                </Popover>
                                <Popover>
                                    <PopoverTrigger asChild>
                                        <Button
                                            variant={"outline"}
                                            className={cn(
                                                "w-full justify-start text-left font-normal",
                                                !data.time_end &&
                                                "text-muted-foreground"
                                            )}
                                        >
                                            {data.time_end
                                                ? format(data.time_end, "p")
                                                : "Waktu Berakhir"}
                                        </Button>
                                    </PopoverTrigger>
                                    <PopoverContent className="w-auto p-0">
                                        <TimePicker
                                            data={data.time_end}
                                            setData={(date) =>
                                                setData("time_end", date)
                                            }
                                        />
                                    </PopoverContent>
                                </Popover>
                            </div>

                            <InputError
                                message={errors.start_time || errors.end_time}
                                className="mt-2"
                            />
                        </div>
                    </div>
                    <div>
                        <div className="">
                            <Label htmlFor="capacity">Kapasitas</Label>
                            <Input
                                id="capacity"
                                name="capacity"
                                value={data.capacity}
                                placeholder="Masukkan Kapasitas Kelas"
                                autoComplete="capacity"
                                onChange={(e) =>
                                    setData("capacity", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.capacity}
                                className="mt-2"
                            />
                        </div>
                        <div>
                            <Label htmlFor="disc">Discount</Label>
                            <Input
                                id="disc"
                                name="disc"
                                value={data.disc}
                                placeholder="Masukkan Diskon Kelas"
                                autoComplete="disc"
                                onChange={(e) =>
                                    setData("disc", e.target.value)
                                }
                            />
                            <InputError
                                message={errors.disc}
                                className="mt-2"
                            />
                        </div>

                        <div className="">
                            <Label htmlFor="price">Harga</Label>
                            <Input
                                id="price"
                                name="price"
                                value={data.cost}
                                placeholder="Masukkan Harga Kelas"
                                autoComplete="price"
                                onChange={(e) =>
                                    setData("cost", e.target.value)
                                }
                            />

                            <InputError
                                message={errors.cost}
                                className="mt-2"
                            />
                        </div>
                        <div className="">
                            <DragDropPhoto
                                path={data.path}
                                errMessage={errors.thumbnail}
                                setData={(e) => {
                                    setData("thumbnail", e);
                                }}
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
                                    <Label htmlFor={element}
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
                                    value={data.class}
                                    onValueChange={(e) => setData("class", e)}
                                >
                                    <SelectTrigger className="">
                                        <SelectValue placeholder="Jenis Kelas"/>
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
                                    <Label htmlFor={element}
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
                        onClick={() =>
                            router.visit(route("admin.course.index"))
                        }
                    >
                        Batal Menambahkan Kelas
                    </Button>
                    <Button disabled={processing} onClick={handleDateChange}>
                        Simpan Kelas
                    </Button>
                </div>
            </form>
        </AdminLayout>
    );
}
