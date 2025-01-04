import {
    Carousel,
    CarouselContent,
    CarouselItem,
    CarouselPagination,
} from "@/components/ui/carousel";
import {cn} from "@/lib/utils";
import Autoplay from "embla-carousel-autoplay";

interface WrapItemProps {
    image: string;
    desc: string;
    textWidth?: string;
}

const WrapItem = ({image, desc, textWidth}: WrapItemProps) => {
    return (
        <div className="h-[calc(100vh-2rem)] relative rounded-[0.5rem] overflow-hidden">
            <img
                src={image}
                className="object-cover w-full h-full"
                alt="shelf"
            />
            <div className="bg-gradient-to-b from-black/10 from-40% to-black/80 absolute inset-0 p-4 ">
                <div className="relative flex justify-center items-end bottom-12 h-full">
                    <p
                        className={cn(
                            textWidth || "w-7/12",
                            "text-[2.75rem] text-center text-white font-medium"
                        )}
                    >
                        {desc}
                    </p>
                </div>
            </div>
        </div>
    );
};

const SliderImage = () => {
    return (
        <Carousel plugins={[Autoplay({delay: 8000})]} opts={{loop: true}}>
            <CarouselContent>
                <CarouselItem>
                    <WrapItem
                        image="images/shelf.jpeg"
                        desc="Guru terbaik untuk anak anda"
                    />
                </CarouselItem>
                <CarouselItem>
                    <WrapItem
                        image="images/stationery.jpeg"
                        desc="Guru terbaik untuk anak anda"
                    />
                </CarouselItem>
                <CarouselItem>
                    <WrapItem
                        image="images/blackboy.jpeg"
                        desc="Dengan guru yang profesional dan berpengalaman"
                        textWidth="w-8/12"
                    />
                </CarouselItem>
            </CarouselContent>
            <CarouselPagination/>
        </Carousel>
    );
};

export default SliderImage;
