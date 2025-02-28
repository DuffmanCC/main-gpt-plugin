# Main GPT

AI-Powered Chat with your WordPress data.

## Description

**Main-GPT** is a powerful WordPress plugin that creates AI-driven chat experiences using your own website content efficiently and cost-effectively. It captures and tokenizes data from posts, pages, and custom post types (including WooCommerce products), storing it in a vector database. Instead of sending all your content to ChatGPT, Main-GPT intelligently retrieves only the most relevant data based on user queries. This makes the AI responses more accurate while significantly reducing token usage and API costs.

Key Features:

- **Efficient AI Chat** – Uses your content while minimizing API costs.
- **Vector Database Storage** – Optimized indexing for fast and relevant searches.
- **Supports Posts, Pages & Custom Post Types** – Works seamlessly with WooCommerce products and other content types.
- **ChatGPT Integration** – Delivers precise, context-aware responses.
- **Cost-Effective** – Only sends essential content to ChatGPT, reducing expenses.
- **Fully Configurable** – Choose which data sources power your chat.

Enhance your WordPress site with intelligent, optimized AI interactions using **Main-GPT!**

## Installation

### 1. Download the Plugin

- Get the latest ZIP file from the last [release](https://github.com/DuffmanCC/main-gpt-plugin/releases)
- Main-GPT GitHub Releases

### 2. Go to your WordPress dashboard

- Navigate to Plugins > Add New.
- Click Upload Plugin and select the downloaded .zip file.
- Click Install Now, then activate the plugin once the installation is complete.
- Configure Main-GPT

### 3. Important

<span style="color: red;">The chat needs to be used as a not-logged-in user.</span>

## Configuration

### 1. Set Up Pinecone (Vector Database)

- Go to [Pinecone](https://www.pinecone.io/) and create a free account.
- Set up a free vector database.
- Copy your **API Key** and save it for later.

### 2. Set Up OpenAI

- Go to [OpenAI](https://platform.openai.com/signup/) and create an account.
- Generate your **API Key** and **API Organization ID**.

### 3. Configure Main-GPT in WordPress

- Navigate to **Main AI > AiSettings** in your WordPress dashboard.
- Enter your **Pinecone API Key** and database details.
- Enter your **OpenAI API Key** and **Organization ID**.
- (Optional) Enable **GDPR Configuration** or leave it as default.

## Training the AI Memory

Once Main-GPT is configured, you can start feeding data into the vector database.

### 1. Create a New AI Memory

- Go to **Main AI > AiMemory** in the WordPress dashboard.
- Click **Add New** to create a new memory.
- Select an **Index Name** and choose a similarity metric:
  - **Euclidean**
  - **Cosine**
  - **Dot Product**

### 2. Train the AI Memory

- Choose the content you want to index (posts, pages, WooCommerce products, etc.).
- Start training the AI by pressing the **START TRAINING MEMORY** button.

### 3. Publish the AI Memory

- Once the training is complete, **don’t forget to publish your AI Memory CPT** to make it active.

## Setting Up the AI Chat

Once the AI Memory is trained, you can configure the chat to use your indexed data.

### 1. Create a New AI Chat

- Go to **MainAI > AiChatter** in the WordPress dashboard.
- Click **Add New** to create a new chat.
- Give it a **name** and configure its settings.

### 2. Configure AI Chat Settings

- Select the **AiMemory** that the chat will use.
- Choose the **OpenAI model** (e.g., `gpt-4`, `gpt-3.5`).
- Set the **Top-K** value (number of retrieved results from the vector database).
- Define the **First Prompt** (how the AI should behave).
- Set an **Initial Message** (default message when chat starts).
- Adjust other configurations as needed (campaigns, contacts, limits).

### 3. Publish & Use the Chat

- **Publish** the AI Chatter CPT to make it active.
- Copy the generated **shortcode** and paste it into any page or post where you want the chat to appear.

## Setting Up AI Campaigns

If you want to show campaigns in each chat to your users, you can create and configure them under **MainAI > AiCampaign**.

### 1. Create a New Campaign

- Go to **MainAI > AiCampaign** in the WordPress dashboard.
- Click **Add New** to create a new campaign.
- Configure the campaign's **content** (what message or offer you want to show).
- Set the **duration** (months) for the campaign.
- Publish the campaign.

### 2. Link Campaign to AI Chat

- After creating the campaign, go back to **AI Chatter**.
- In the chat settings, select which **AI Campaign** will be shown to users during the chat.
