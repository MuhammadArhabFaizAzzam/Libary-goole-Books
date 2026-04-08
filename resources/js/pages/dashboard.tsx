import { Head, Link } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { 
    Search, Clock, Star, Bookmark, 
    Sparkles, Flame, Zap, Ghost 
} from 'lucide-react';
import { Card, CardContent } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Badge } from '@/components/ui/badge';
import { motion, AnimatePresence } from 'framer-motion';
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";

// Data Buku dengan vibe Anime/Manga
const animeBooks = [
    { id: 1, title: 'Solo Leveling Vol. 1', author: 'Chugong', color: 'from-blue-600 to-cyan-400', tag: 'Action' },
    { id: 2, title: 'Blue Lock', author: 'Muneyuki Kaneshiro', color: 'from-indigo-600 to-blue-500', tag: 'Sports' },
    { id: 3, title: 'Frieren: Beyond Journey\'s End', author: 'Kanehito Yamada', color: 'from-emerald-400 to-teal-600', tag: 'Fantasy' },
    { id: 4, title: 'Oshi No Ko', author: 'Aka Akasaka', color: 'from-pink-500 to-purple-600', tag: 'Drama' },
];

export default function AnimeDashboard() {
    return (
        <AppLayout>
            <Head title="Otaku Library" />
            
            <div className="p-6 space-y-8 max-w-7xl mx-auto font-sans selection:bg-pink-500 selection:text-white">
                
                {/* 1. Anime Style Presence Bar */}
                <div className="flex items-center justify-between bg-white/80 backdrop-blur-md p-4 rounded-xl border-b-4 border-r-4 border-indigo-600 shadow-[8px_8px_0px_0px_rgba(79,70,229,0.2)]">
                    <div className="flex items-center gap-4">
                        <div className="flex -space-x-2">
                            {[1, 2].map((u) => (
                                <motion.div key={u} initial={{ scale: 0 }} animate={{ scale: 1 }} whileHover={{ y: -5 }}>
                                    <Avatar className="border-2 border-indigo-600 w-10 h-10 ring-2 ring-white">
                                        <AvatarFallback className="bg-pink-500 text-white font-black">U{u}</AvatarFallback>
                                    </Avatar>
                                </motion.div>
                            ))}
                        </div>
                        <div>
                            <div className="flex items-center gap-2">
                                <span className="h-2 w-2 bg-green-500 rounded-full animate-pulse" />
                                <h3 className="text-xs font-black uppercase tracking-tighter text-slate-900">2 Players Online</h3>
                            </div>
                        </div>
                    </div>
                    <Badge className="bg-indigo-600 hover:bg-indigo-700 rounded-none skew-x-[-12deg] font-black uppercase italic">
                        System: Normal
                    </Badge>
                </div>

                {/* 2. Hero Section: Cyberpunk/Anime Vibe */}
                <section className="relative overflow-hidden rounded-[2rem] bg-slate-950 p-8 md:p-14 text-white border-4 border-indigo-500 shadow-[0_0_30px_rgba(79,70,229,0.4)]">
                    <div className="relative z-10">
                        <motion.div 
                            initial={{ x: -50, opacity: 0 }} 
                            animate={{ x: 0, opacity: 1 }}
                            className="inline-block bg-pink-500 text-white text-[10px] font-bold px-3 py-1 mb-4 skew-x-[-15deg] uppercase"
                        >
                            Welcome Back, Senpai!
                        </motion.div>
                        <h1 className="text-5xl md:text-6xl font-black italic tracking-tighter leading-none mb-6">
                            CARI <span className="text-indigo-400 drop-shadow-[0_0_10px_rgba(129,140,248,0.8)]">BACAAN</span> <br />
                            MU SEKARANG!
                        </h1>
                        
                        <div className="mt-8 relative group max-w-xl">
                            <Input 
                                placeholder="Search Manga, Novel, or Author..." 
                                className="h-16 pl-6 pr-16 rounded-none border-l-8 border-pink-500 bg-white/10 backdrop-blur-xl text-white placeholder:text-slate-400 focus-visible:ring-0 focus-visible:border-indigo-400 transition-all text-xl font-bold"
                            />
                            <div className="absolute right-2 top-1/2 -translate-y-1/2 bg-indigo-600 p-3 hover:bg-pink-500 transition-colors cursor-pointer">
                                <Search className="w-6 h-6" />
                            </div>
                        </div>
                    </div>
                    
                    {/* Decorative Background Icons */}
                    <Zap className="absolute top-10 right-10 w-32 h-32 text-indigo-500/20 rotate-12" />
                    <Sparkles className="absolute bottom-10 right-40 w-20 h-20 text-pink-500/20 -rotate-12" />
                </section>

                {/* 3. Grid Content */}
                <div className="grid grid-cols-1 lg:grid-cols-3 gap-10">
                    <div className="lg:col-span-2 space-y-10">
                        
                        {/* Rekomendasi Buku: Anime Style Cards */}
                        <div className="space-y-6">
                            <h2 className="text-2xl font-black italic uppercase flex items-center gap-3 text-slate-900 underline decoration-pink-500 decoration-4 underline-offset-8">
                                <Flame className="w-7 h-7 text-orange-500" /> Hot Recommendations
                            </h2>
                            
                            <div className="grid grid-cols-2 sm:grid-cols-4 gap-6">
                                {animeBooks.map((book) => (
                                    <motion.div 
                                        key={book.id} 
                                        whileHover={{ scale: 1.05, rotate: -2 }}
                                        className="relative group cursor-pointer"
                                    >
                                        <div className={`aspect-[2/3] rounded-none border-4 border-slate-900 bg-gradient-to-br ${book.color} shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] overflow-hidden relative transition-all group-hover:shadow-[12px_12px_0px_0px_rgba(236,72,153,1)]`}>
                                            <div className="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]" />
                                            
                                            {/* Tag Manga Style */}
                                            <div className="absolute top-2 left-2 bg-black text-white text-[10px] font-bold px-2 py-1 z-10 skew-x-[-10deg]">
                                                {book.tag}
                                            </div>

                                            {/* Efek Hover Glass */}
                                            <div className="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-sm">
                                                <Zap className="text-white w-12 h-12 animate-pulse" />
                                            </div>
                                        </div>
                                        <div className="mt-4">
                                            <h4 className="font-black text-sm uppercase tracking-tight text-slate-900 group-hover:text-pink-600 leading-tight">
                                                {book.title}
                                            </h4>
                                            <p className="text-[10px] font-bold text-slate-500 mt-1 italic">{book.author}</p>
                                        </div>
                                    </motion.div>
                                ))}
                            </div>
                        </div>
                    </div>

                    {/* 4. Sidebar: Profile Card Anime Style */}
                    <div className="space-y-8">
                        <Card className="bg-indigo-600 border-4 border-slate-900 rounded-none shadow-[10px_10px_0px_0px_rgba(0,0,0,1)] text-white overflow-hidden relative">
                            <CardContent className="p-6 relative z-10">
                                <div className="flex justify-between items-center mb-8">
                                    <div className="bg-black text-[10px] px-2 py-1 font-black italic">LVL. 99 MEMBER</div>
                                    <Ghost className="w-6 h-6 text-white/40" />
                                </div>
                                <div className="space-y-1">
                                    <p className="text-[10px] uppercase font-bold text-indigo-200 tracking-widest text-shadow-sm">Citizen Name</p>
                                    <h3 className="text-3xl font-black italic uppercase tracking-tighter">Arisaka John</h3>
                                </div>
                                <div className="mt-10 pt-6 border-t-2 border-dashed border-white/30 flex justify-between items-end">
                                    <div>
                                        <p className="text-[10px] font-bold text-indigo-200">ACCUMULATED EXP</p>
                                        <p className="text-2xl font-black tracking-tighter text-pink-400">9,999 PTS</p>
                                    </div>
                                    <div className="w-12 h-12 bg-white rounded-none flex items-center justify-center border-2 border-black rotate-12 shadow-[4px_4px_0px_rgba(0,0,0,1)]">
                                        <Zap className="text-indigo-600 w-6 h-6" />
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                        
                        {/* Recent Activity: Log Style */}
                        <div className="bg-slate-50 border-2 border-slate-200 p-5 rounded-none shadow-[4px_4px_0px_0px_rgba(0,0,0,0.05)]">
                            <h3 className="text-sm font-black italic uppercase border-b-2 border-slate-900 pb-2 mb-4">Latest Logs</h3>
                            <div className="space-y-4">
                                {[1, 2].map((i) => (
                                    <div key={i} className="flex gap-3 items-start group">
                                        <div className="w-2 h-6 bg-pink-500 mt-1 group-hover:scale-y-150 transition-transform" />
                                        <div>
                                            <p className="text-xs font-bold text-slate-800 leading-tight">Captured "Solo Leveling" to Wishlist.</p>
                                            <p className="text-[10px] text-slate-400 mt-1 italic font-mono">timestamp: 14.20.00</p>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}